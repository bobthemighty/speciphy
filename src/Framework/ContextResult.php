<?php
namespace Speciphy\Framework;
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
