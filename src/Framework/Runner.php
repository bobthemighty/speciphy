<?php

namespace Speciphy\Framework;

use mindplay\annotations\Annotations;
use Speciphy\Framework\Annotations\ContextAnnotation;
use Speciphy\Framework\Annotations\AssertionAnnotation;
use Speciphy\Framework\Annotations\IgnoreAnnotation;
include_once "Annotations/AnnotationConfig.php";
    
class Runner
{

    function __construct()
    {
       $this->finder = new \Speciphy\Framework\Finders\RecursiveDirectorySearchingClassFinder(getcwd());
       $this->selector = new \Speciphy\Framework\Finders\ContextSelector();
       $this->builder = new ContextBuilder();
    }


    function Run()
    {
        $contexts = $this->selector->select(
            $this->finder->find());
        $reporter = new \Speciphy\Framework\Recorder\ColouredConsoleReporter();
        $reporter->recordSuiteStart();
        foreach($contexts  as $t)
        {
            $cls = new \ReflectionClass($t);
            $ctx = $this->builder->build($cls);
            $ctx->execute($reporter);
        }
        $reporter->recordSuiteEnd();
    }
   }
