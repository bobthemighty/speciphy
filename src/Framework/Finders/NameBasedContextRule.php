<?php

namespace Speciphy\Framework\Finders;

class NameBasedContextRule implements IContextSelectionRule
{
    function isContext($c)
    {
        $words = explode("_", $c);
        if($words[0] === "When")
        {
            return true;
        }
        return false;
    }
}

