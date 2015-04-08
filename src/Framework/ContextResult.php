<?php
namespace Speciphy\Framework;

class ContextResult
{

    function __construct(){
        $this->asserts = [];
        $this->action = false;
        $this->setup =  false;
        $this->reporter = new ColouredConsoleReporter();
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

