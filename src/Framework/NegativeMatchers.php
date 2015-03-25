<?php
namespace Speciphy\Framework;
class NegativeMatchers
{
    public function __construct($expectation)
    {
        $this->expectation = $expectation;
    }

    public function be_true()
    {
        if($this->expectation->subject === false)
        {
            return;
        }
        throw new ExpectationException("Expected not true but was "+$this->expectation->subject);
    }
    
    public function be_false()
    {
        if($this->expectation->subject === false)
        {
          throw new Exception("Expected not false but was ".$this->expectation->subject);
        }
    }

    function equal($expected)
    {
        if($this->expectation->subject == $expected)
        {
            throw new Exception("Expected not ". $expected. " but was " . $expectation->subject);
        }
    }
}


