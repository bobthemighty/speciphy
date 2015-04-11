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

function buildRunner() {
    


}
