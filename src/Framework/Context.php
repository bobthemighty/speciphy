<?php
namespace Speciphy\Framework;
class Context
{
    function __construct($cls, $given, $when, $then)
    {
        if(!$given){ $given = null; }
        if(!$when){ $when = null; }
        
        $this->checkAmbiguity($given, $when);
       
        $this->cls = $cls;
        $this->given = $given[0];
        $this->action= $when[0];
        $this->then = $then;
    }

    function checkAmbiguity($given, $when)
    {
        if($when != null
            && $when == $given)
            throw new \Exception("ambiguous, blud");
        if(count($given) > 1)
            throw new \Exception("ambiguous, blud");
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
            catch(\Exception $e)
            {
                $recorder->recordFailure($assertion->name, $e->getMessage());
            }
        }
    }
}
