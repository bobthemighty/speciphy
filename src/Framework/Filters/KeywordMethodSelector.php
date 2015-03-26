<?php

namespace Speciphy\Framework\Filters;

class KeywordMethodSelector implements ISelectMethods
{
    function __construct($keywords)
    {
        $this->keywords = $keywords;
    }

    function select($method)
    {
        $words = explode("_", $method->name);
        foreach($words as $word)
        {
            foreach($this->keywords as $kw) {
            if($word == $kw){
                return true;
            }
            }
        }
    }
}
