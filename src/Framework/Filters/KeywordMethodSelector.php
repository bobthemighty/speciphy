<?php

namespace Speciphy\Framework\Filters;

class KeywordMethodSelector implements ISelectMethods
{
    function __construct($keyword)
    {
        $this->keyword = $keyword;
    }

    function select($method)
    {
        $words = explode("_", $method->name);
        foreach($words as $word)
        {
            if($word == $this->keyword){
                return true;
            }
        }
    }
}
