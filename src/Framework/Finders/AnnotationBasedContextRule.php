<?php

namespace Speciphy\Framework\Finders;

use mindplay\annotations\Annotations;
use Speciphy\Framework\Annotations\ContextAnnotation;

class AnnotationBasedContextRule implements IContextSelectionRule
{
    function isContext($class)
    {
        $annotations = Annotations::ofClass($class);
        foreach($annotations as $a)
        {
            if($a instanceof ContextAnnotation)
            {
                return true;
            }
        }
        return false;
    }
}

