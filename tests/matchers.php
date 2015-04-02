<?php

use Hamcrest\Matcher;

class IsMethod implements Matcher
{
    function __construct($method)
    {
        $this->method = $method;
    }

    function describeTo(Hamcrest\Description $description)
    {
        $this->desc($description, $this->method);
    }

    function matches($subject)
    {
        return ($subject instanceof \ReflectionMethod) &&
               ($subject->class == $this->method->class) &&
               ($subject->name == $this->method->name);  
    }

    function describeMismatch($subject, Hamcrest\Description $description)
    {
        $this->desc($description, $subject);
    }

    function desc($description, $method)
    {
        $description->appendText("method ".$method->class . "::" . $method->name);
    }
}

function isMethod($m){ return new IsMethod($m); }

class Throws implements Matcher
{

    const NOT_CALLABLE = 1;
    const NO_EXCEPTION = 2;
    const SUCCESS = 0;

    function __construct($matcher = null)
    {
        $this->exnMatcher = $matcher;
    }

    function describeTo(Hamcrest\Description $description)
    {
        $description->appendText("a function throwing an exception");
        if($this->exnMatcher)
        {
            $this->exnMatcher->describeTo($description);
        }
    }

    function describeMismatch($subject, Hamcrest\Description $description)
    {
        switch($this->match($subject))
        {
            case 0:
                return;
            case 1:
                $description->appendText("not callable");
                return;
            case 2:
                $description->appendText("not an exception");
        }
    }

    function match($subject)
    {
        if(false == is_callable($subject))
        {
            return 1;
        }
        try
        {
            call_user_func($subject);
            return 2;
        }
        catch(\Exception $e)
        {
            return 0;
        }
    }

    function matches($subject)
    {
       return $this->match($subject) == 0; 
    }

}

function throws($next=null){ return new Throws($next); }
