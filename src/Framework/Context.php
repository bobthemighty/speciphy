<?php
namespace Speciphy\Framework;
class Context
{
    function __construct($cls, $given, $when, $then)
    {
        if(!$given){ $given = null; }
        if(!$when){ $when = null; }
        $this->cls = $cls;
        $this->given = $given;
        $this->action= $when;
        $this->then = $then;

        $this->checkAmbiguity();
    }

    function checkAmbiguity()
    {
        if($this->action != null
            && $this->action == $this->given)
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
