<?php
namespace Speciphy\Framework;
class Expectation
{
    public function __construct($subject, $matcher)
    {
        $this->subject = $subject;
        $this->mather = $matcher;
    }
}


