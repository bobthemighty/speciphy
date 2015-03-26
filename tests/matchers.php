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


