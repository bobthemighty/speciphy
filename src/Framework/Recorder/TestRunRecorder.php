<?php

namespace Speciphy\Framework\Recorder;

interface TestRunRecorder
{
    public function recordContextStart($ctx);
    public function recordContextEnd($err=null);
    public function recordSetupStart();
    public function recordSetupEnd($err=null);
    public function recordActionStart();
    public function recordActionEnd($err=null);
    public function recordAssertionStart($assertion);
    public function recordAssertionEnd($err=null);
    public function recordSuiteStart();
    public function recordSuiteEnd($err=null);
}


