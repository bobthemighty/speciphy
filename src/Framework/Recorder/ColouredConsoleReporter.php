<?php

namespace Speciphy\Framework\Recorder;

use Speciphy\Framework\Color;

class ColouredConsoleReporter implements TestRunRecorder
{

    private $startTime;
    private $failures;
    private $currentContext;
    private $currentAssert;
    private $asserts = 0;
    private $contexts = 0;


    function __construct()
    {
        $this->formatter = new CamelCaseNameFormatter();
    }

    public function recordSuiteStart(){
        $startTime = microtime(true);
    }

    public function recordContextStart($ctx){
        $this->currentContext = $this->formatter->format($ctx);
        $this->contexts ++;
        echo $this->currentContext .  PHP_EOL;
    }

    public function recordContextEnd($err=null){}
    public function recordSetupStart(){}
    public function recordSetupEnd($err=null){}
    public function recordActionStart(){}
    public function recordActionEnd($err=null){}
    public function recordAssertionStart($assert)
    {
        $this->currentAssert = $this->formatter->format($assert);
        $this->asserts ++;
    }
    public function recordAssertionEnd($err=null){
        if($err)
        {
            $this->failures[] = new AssertionFailure($this->currentContext, $this->currentAssert, $err->getMessage());
            echo "  FAIL: " . $this->currentAssert . PHP_EOL . "    " . $err->getMessage();
        }
        else
        {
            echo "  PASS: " .$this->currentAssert . PHP_EOL;
        }
    }
    public function recordSuiteEnd($err=null){
        echo(PHP_EOL);

        if($this->isSuccess())
        {
            echo(Color::set("PASSED!" . PHP_EOL, "green+bold"));
        }
        else
        {
            echo(Color::set("FAILED!" . PHP_EOL, "red+bold"));
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


