<?php

namespace Speciphy\Framework\Filters;

use mindplay\annotations\Annotations;
use Speciphy\Framework\Annotations\AssertionAnnotation;

class AssertionAnnotationSelector implements ISelectMethods
{
    function select($method)
    {
        $annotations = Annotations::ofMethod($method->class, $method->name);
        foreach($annotations as $a)
        {
            if($a instanceof AssertionAnnotation)
            {
                return true;
            }
        }
    }

}
