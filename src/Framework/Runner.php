<?php


namespace Speciphy\Framework;

use mindplay\annotations\Annotations;
use Speciphy\Framework\Annotations\ContextAnnotation;
use Speciphy\Framework\Annotations\AssertionAnnotation;
use Speciphy\Framework\Annotations\IgnoreAnnotation;
include_once "Annotations/AnnotationConfig.php";
    
interface IFindClasses{

    public function find();

}

class RecursiveDirectorySearchingClassFinder implements IFindClasses
{

    function __construct($dir)
    {
        $this->workingDir = $dir;
    }

    public function find()
    {
        $shiz = get_declared_classes();

        $Directory = new \RecursiveDirectoryIterator($this->workingDir);
        $Iterator = new \RecursiveIteratorIterator($Directory);
        $Regex = new \RegexIterator($Iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH); 

        foreach($Regex as $file){ 
            include_once $file[0];
        }

        return array_diff(get_declared_classes(), $shiz);
    }
}

interface ISelectContexts{

    public function select($classes);
}

interface IContextSelectionRule{
    public function isContext($class);
}








class RunnerBuilder
{
    function build()
    {
        return new Runner();
    }
}


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

class ContextSelector implements ISelectContexts
{

    function __construct()
    {
        $this->rules = [
            new NameBasedContextRule(),
            new AnnotationBasedContextRule()
            ];
    }

    function is_context($c)
    {
        foreach($this->rules as $r)
        {
            if($r->isContext($c))
                return true;
        }
    }

    function select($classes)
    {
        return array_filter($classes, [$this, 'is_context']);
    }


}

class Runner
{

    function __construct()
    {
       $this->finder = new RecursiveDirectorySearchingClassFinder(getcwd());
       $this->selector = new ContextSelector();
       $this->builder = new ContextBuilder();
    }


    function Run()
    {
        $contexts = $this->selector->select(
        $this->finder->find());
        foreach($contexts  as $t)
        {
            $cls = new \ReflectionClass($t);
            $ctx = $this->builder->build($cls);
            $ctx->execute()->report();
        }
    }
   }
