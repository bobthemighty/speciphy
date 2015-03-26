<?php

namespace Speciphy\Framework;
use Speciphy\Framework\Filters\MethodFilter;
use Speciphy\Framework\Filters\KeywordMethodSelector;
use Speciphy\Framework\Filters\AssertionAnnotationSelector;
use Speciphy\Framework\Filters\NospecRejector;


class ContextBuilder
{

    function __construct()
    {
        $this->assertionFilter = new MethodFilter([new KeywordMethodSelector(["should"]), new AssertionAnnotationSelector()], [new NospecRejector()]);
        $this->setupFilter = new MethodFilter([new KeywordMethodSelector(["setup", "given"])], []);
    }

    function is_keyword($kw, $w)
    {
        return strcasecmp($kw, $w) == 0;
    }


    function is_action($f)
    {
        $words = explode("_", $f->name);
        foreach($words as $word)
        {
            if($this->is_keyword("when", $word))
                return true;
            if($this->is_keyword("because", $word))
                return true;
        }
        return false; 
    }
    
    function build($class)
    {
         $methods = $class->getMethods();
         $ctx = new Context($class,
                 reset($this->setupFilter->filter($methods)),
                 reset(array_filter($methods, array($this,'is_action'))),
                 $this->assertionFilter->filter($methods)); 


        return $ctx;
    }
}
