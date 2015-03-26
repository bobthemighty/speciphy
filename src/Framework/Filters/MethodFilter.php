<?php

namespace Speciphy\Framework\Filters;

class MethodFilter
{
    function __construct($selectors, $rejectors)
    {
        $this->selectors = $selectors;
        $this->rejectors = $rejectors;
    }

    public function filter($methods)
    {
        return iterator_to_array($this->reject(
            $this->select($methods)),
            false
        );

    }

    private function select($methods)
    {
        foreach($methods as $m)
        {
            foreach($this->selectors as $rule)
            {
                if($rule->select($m))
                {
                    yield $m;
                }
            }
        }
    }

    private function reject($methods)
    {
        foreach($methods as $m)
        {
            $rejected = false;
            foreach($this->rejectors as $rule)
            {
                if($rule->reject($m))
                {
                    $rejected = true;
                    break;
                }
            }
            if(false == $rejected)
                yield $m;
        }
    }
}


