<?php

namespace Speciphy\Framework\Filters;

use mindplay\annotations\Annotations;
use Speciphy\Framework\Annotations\IgnoreAnnotation;

class NospecRejector implements IRejectMethods
{
    function reject($method)
    {
         $annotations = Annotations::ofMethod($method->class, $method->name);
        foreach($annotations as $a)
        {
            if($a instanceof IgnoreAnnotation)
            {
                return true;
            }
        }
    }
}


