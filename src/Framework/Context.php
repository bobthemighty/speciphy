<?php
namespace Speciphy\Framework;
class Context
{
    function __construct($cls, $given, $when, $then, $cleanups)
    {
        if(!$given){ $given = null; }
        if(!$when){ $when = null; }
        
        $this->checkAmbiguity($given, $when);
       
        $this->cls = $cls;
        $this->given = $given[0];
        $this->action= $when[0];
        $this->then = $then;
        $this->cleanups = $cleanups;
    }

    function checkAmbiguity($given, $when)
    {
        if($when != null
            && $when == $given)
            throw new \Exception("ambiguous, blud");
        if(count($given) > 1)
            throw new \Exception("ambiguous, blud");
    }

    function execute(\Speciphy\Framework\Recorder\TestRunRecorder $recorder)
    {
        $recorder->recordContextStart($this->cls->name);
        $ctx = $this->cls->newInstance();

        $this->executeGiven($ctx, $recorder);
        $this->executeAction($ctx, $recorder);
        $this->executeAssertions($ctx, $recorder);        
        $this->cleanup($ctx);
        return $recorder;
    }

    function executeGiven($ctx, $recorder)
    {
       if($this->given)
       {
               $recorder->recordSetupStart($this->given->name);
               $this->given->invoke($ctx);
               $recorder->recordSetupEnd();
        }
    }
    
    function executeAction($ctx, $recorder)
    {
        if($this->action)
        {
            $recorder->recordActionStart($this->action->name);
            $this->action->invoke($ctx);
            $recorder->recordActionEnd();
        }
    }

    function executeAssertions($ctx, $recorder)
    {
        foreach($this->then as $assertion)
        {
            try
            {
                $recorder->recordAssertionStart($assertion->name);
                $assertion->invoke($ctx);
                $recorder->recordAssertionEnd();
            }
            catch(\Exception $e)
            {
                $recorder->recordAssertionEnd($e);
            }
        }
    }

    function cleanup($ctx)
    {
        if($this->cleanups){
            foreach($this->cleanups as $cleanup)
            {
                $cleanup->invoke($ctx);
            }
        }
    }
}
