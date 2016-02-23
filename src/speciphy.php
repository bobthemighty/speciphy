<?php
require_once "../vendor/autoload.php";

$definitions = new \Clapp\CommandLineArgumentDefinition(array(
    "help|h"    => "Shows this help",
    "verbose|v" => "Show full output of tests",
    "dir|d=s"      => "A directory to search for contexts",
    "file|f=s"     => "A single file to search for contexts"));

$filter = new \Clapp\CommandArgumentFilter($definitions, $argv);

if($filter->getParam("h") == true) {
    fwrite(STDERR, $definitions->getUsage());
    exit(0);
}

function getFinder($dir = null, $file = null) 
{
    if($dir){
        return new Speciphy\Framework\Finders\RecursiveDirectorySearchingClassFinder($dir);
    }
    if($file){
        die("not implemented");
    }

    return new Speciphy\Framework\Finders\RecursiveDirectorySearchingClassFinder(getcwd());
}


function buildRunner($args) 
{

    $finder = getFinder($args->getParam("d"), $args->getParam("f"));

    return new \Speciphy\Framework\Runner($finder);
}

$runner = buildRunner($filter);
$runner->Run();
