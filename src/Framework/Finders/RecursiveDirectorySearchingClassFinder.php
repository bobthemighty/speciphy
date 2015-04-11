<?php

namespace Speciphy\Framework\Finders;

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


