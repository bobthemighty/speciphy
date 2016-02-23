<?php

namespace Speciphy\Framework;

use mindplay\annotations\Annotations;
use Speciphy\Framework\Annotations\ContextAnnotation;
use Speciphy\Framework\Annotations\AssertionAnnotation;
use Speciphy\Framework\Annotations\IgnoreAnnotation;
use Speciphy\Framework\Finders\IFindClasses;
use Speciphy\Framework\Finders\ISelectContexts;
use Speciphy\Framework\Finders\RecursiveDirectorySearchingClassFinder;
use Speciphy\Framework\Finders\ContextSelector;
use Speciphy\Framework\Recorder\TestRunRecorder;
use Speciphy\Framework\Recorder\ColouredConsoleReporter;
include_once "Annotations/AnnotationConfig.php";
    
class Runner
{

    function __construct(IFindClasses $finder = null,
                         ISelectContexts $selector = null,
                         ContextBuilder $builder = null,
                         TestRunRecorder $recorder = null) {

       $this->finder = ($finder) ?: new RecursiveDirectorySearchingClassFinder(getcwd());
       $this->builder = ($builder) ?: new ContextBuilder();
       $this->selector = ($selector) ?: new ContextSelector();
       $this->recorder = ($recorder) ?:  new ColouredConsoleReporter();
    }



    function Run()
    {
        $contexts = $this->selector->select($this->finder->find());
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
