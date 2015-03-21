<?php

include_once "ansi-color.php";

use PhpAnsiColor\Color; 

class PositiveMatchers
{

    public function __construct($expectation)
    {
        $this->expectation = $expectation;
    }

    public function be_true()
    {
        if($this->expectation->subject === true)
        {
            return;
        }
        throw new ExpectationException("Expected true but was "+$this->expectation->subject);
    }
    function equal($expected)
    {
        if($this->expectation->subject == $expected)
        {
            return;
        }
        throw new Exception("Expected ". $expected. " but was " . $this->expectation->subject);
    }
}

class NegativeMatchers
{
    public function __construct($expectation)
    {
        $this->expectation = $expectation;
    }

    public function be_true()
    {
        if($this->expectation->subject === false)
        {
            return;
        }
        throw new ExpectationException("Expected not true but was "+$this->expectation->subject);
    }
    
    public function be_false()
    {
        if($this->expectation->subject === false)
        {
          throw new Exception("Expected not false but was ".$this->expectation->subject);
        }
    }

    function equal($expected)
    {
        if($this->expectation->subject == $expected)
        {
            throw new Exception("Expected not ". $expected. " but was " . $expectation->subject);
        }
    }
}

class Expectation
{
    public function __construct($subject)
    {
        $this->subject = $subject;
        $this->to = new PositiveMatchers($this);
        $this->to_not = new NegativeMatchers($this);
    }
}



class AssertionResult
{
    function __construct($name, $success, $msg = NULL)
    {
        $this->name = $name;
        $this->success = $success;
        $this->msg = $msg;
    }
}

class ContextResult
{

    function __construct(){
        $this->asserts = [];
        $this->action = false;
        $this->setup =  false;
    }

    function format($name)
    {
        return str_replace("_", " ", $name);
    }

    function recordContext($name)
    {
        $this->contextName = $this->format($name);
    }

    function recordSetup($name)
    {
        $this->setup = $this->format($name);
    }

    function recordAction($name)
    {
        $this->action = $this->format($name);
    }

    function recordSuccess($name)
    {
        $report = new AssertionResult($this->format($name), true);
        $this->asserts[$this->format($name)] = $report;
    }

    function recordFailure($name, $err)
    {
        $report = new AssertionResult($this->format($name), false, $err);
        $this->asserts[$this->format($name)] = $report;
    }

    function report()
    {
        if($this->is_successful())
        {
            error_log(Color::set($this->contextName, "green+bold+underline"));
        }
        else
        {
            error_log(Color::set($this->contextName, "red+bold+underline"));
        }

        if($this->setup)
        {
            error_log(Color::set("* ". $this->setup, "bold+white"));
        }

        if($this->action)
        {
            error_log(Color::set("* ". $this->action, "bold+white"));
        }

        foreach($this->asserts as $assert)
        {
            if($assert->success) 
            {
                error_log(Color::set("\t* ". $assert->name, "white"));
            }
            else
            {
                error_log(Color::set("\t* ". $assert->name, "red"));
                error_log(Color::set("\t** ". $assert->msg, "yellow"));
            }
        }
    }

    function is_successful()
    {
        foreach($this->asserts as $assert)
        {
            if($assert->success == false)
                return false;
        }
        return true;
    }
}

class Context
{
    function __construct($cls, $given, $when, $then)
    {
        $this->cls = $cls;
        $this->given = $given;
        $this->action= $when;
        $this->then = $then;
    }

    function execute()
    {
        $recorder = new ContextResult();
        $recorder->recordContext($this->cls->name);
        $ctx = $this->cls->newInstance();

        $this->executeGiven($ctx, $recorder);
        $this->executeAction($ctx, $recorder);
        $this->executeAssertions($ctx, $recorder);        
        return $recorder;
    }

    function executeGiven($ctx, $recorder)
    {
       if($this->given)
       {
           $this->given->invoke($ctx);
           $recorder->recordSetup($this->given->name);
       }
    }
    
    function executeAction($ctx, $recorder)
    {
        if($this->action)
        {
            $this->action->invoke($ctx);
            $recorder->recordAction($this->action->name);
        }
    }

    function executeAssertions($ctx, $recorder)
    {
        foreach($this->then as $assertion)
        {
            try
            {
                $assertion->invoke($ctx);
                $recorder->recordSuccess($assertion->name);
            }
            catch(Exception $e)
            {
                $recorder->recordFailure($assertion->name, $e->getMessage());
            }
        }
    }
}

function is_context($c)
{
    $words = explode("_", $c);
    return $words[0] === "When";
}

function is_action($f)
{
    $words = explode("_", $f->name);
    return in_array("when", $words);
}

function is_setup($f)
{
    $words = explode("_", $f->name);
    return in_array("given", $words);
}

function is_assert($f)
{
    $words = explode("_", $f->name);
    foreach($words as $word)
    {
        if($word == "should")
            return true;
    }
    return false;
}

function expect($subject)
{
    return new Expectation($subject);
}


