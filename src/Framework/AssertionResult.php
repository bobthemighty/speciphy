<?php

namespace Speciphy\Framework;

class AssertionResult
{
    function __construct($name, $success, $msg = NULL)
    {
        $this->name = $name;
        $this->success = $success;
        $this->msg = $msg;
    }
}
