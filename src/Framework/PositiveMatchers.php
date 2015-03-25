<?php

namespace Speciphy\Framework;
class PositiveMatchers
{

    public function __construct($expectation)
    {
        $this->expectation = $expectation;
    }

    public function be_true()
    {
        if($this->expectation->subject === true)
        {
            return;
        }
        throw new \Exception("Expected true but was " . $this->expectation->subject);
    }

    public function be_false()
    {
        if($this->expectation->subject === false)
        {
            return;
        }
        throw new \Exception("Expected false but was " . $this->expectation->subject);
    }
    function equal($expected)
    {
        if($this->expectation->subject == $expected)
        {
            return;
        }
        throw new Exception("Expected ". $expected. " but was " . $this->expectation->subject);
    }
}
