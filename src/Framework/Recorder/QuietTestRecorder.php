<?php

namespace Speciphy\Framework\Recorder;

use Speciphy\Framework\Recorder\TestRunRecorder;

class QuietTestRecorder implements TestRunRecorder
{

    private $formatter;
    
    private $contexts = 0;
    private $asserts  = 0;
    private $failures = [];
    private $currentContext;
    private $currentMethod;

    function __construct()
    {
        $this->formatter = new CamelCaseNameFormatter();
    }

    public function recordContextStart($ctx){
        $this->currentContext = $this->formatter->format($ctx);
        $this->contexts ++;  
    }
    
    public function recordContextEnd($err=null){
    }

    public function recordSetupStart(){}
    public function recordSetupEnd($err=null){}
    public function recordActionStart(){}
    public function recordActionEnd($err=null){}
    
    public function recordAssertionStart($assert){
        $this->asserts ++;
        $this->currentMethod = $this->formatter->format($assert);
    }

    public function recordAssertionEnd($err=null){
        if($err==null) {
            echo('.');
        }
        else{
            echo ('F');
            $this->failures[] = new AssertionFailure($this->currentContext, $this->currentMethod, $err->getMessage());
        }


    }
    public function recordSuiteStart(){}
    public function recordSuiteEnd($err=null){
        echo(PHP_EOL);

        if($this->isSuccess())
        {
            echo("PASSED!" . PHP_EOL);
        }
        else
        {
            echo("FAILED!" . PHP_EOL);
            foreach($this->failures as $fail)
            {
                echo($fail->getMessage() . PHP_EOL);
            }
        }

        echo sprintf("%d contexts, %d assertions" . PHP_EOL, $this->contexts, $this->asserts);
    }

    private function isSuccess()
    {
        return count($this->failures) == 0;
    }
}
