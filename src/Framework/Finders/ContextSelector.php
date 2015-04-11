<?php

namespace Speciphy\Framework\Finders;

class ContextSelector implements ISelectContexts
{

    function __construct()
    {
        $this->rules = [
            new NameBasedContextRule(),
            new AnnotationBasedContextRule()
            ];
    }

    function is_context($c)
    {
        foreach($this->rules as $r)
        {
            if($r->isContext($c))
                return true;
        }
    }

    function select($classes)
    {
        return array_filter($classes, [$this, 'is_context']);
    }


}

