<?php

namespace Speciphy\Framework;
use Speciphy\Framework\Filters\MethodFilter;
use Speciphy\Framework\Filters\KeywordMethodSelector;
use Speciphy\Framework\Filters\AssertionAnnotationSelector;
use Speciphy\Framework\Filters\SetupAnnotationSelector;
use Speciphy\Framework\Filters\ActAnnotationSelector;
use Speciphy\Framework\Filters\NospecRejector;


class ContextBuilder
{

    function __construct()
    {
        $this->assertionFilter = new MethodFilter([new KeywordMethodSelector(["should"]), new AssertionAnnotationSelector()], [new NospecRejector()]);
        $this->actionFilter = new MethodFilter([new KeywordMethodSelector(["because", "when"]), new ActAnnotationSelector()], [new NospecRejector()]);
        $this->setupFilter = new MethodFilter([new KeywordMethodSelector(["setup", "given", "establish"]), new SetupAnnotationSelector()], [new NospecRejector()]);
    }
    
    function build($class)
    {
         $methods = $class->getMethods();
         $ctx = new Context($class,
                 reset($this->setupFilter->filter($methods)),
                 reset($this->actionFilter->filter($methods)),
                 $this->assertionFilter->filter($methods)); 


        return $ctx;
    }
}
