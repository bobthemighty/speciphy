<?php
namespace Speciphy\Framework\Recorder;

class AssertionFailure
{
    function __construct($context, $assertion, $message)
    {
        $this->context = $context;
        $this->assertion = $assertion;
        $this->message = $message;
    }

    function getMessage()
    {
        return $this->context . ": ". $this->assertion . 
            PHP_EOL . 
            "\t" . $this->message;
    }
}


