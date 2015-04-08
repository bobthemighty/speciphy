<?php

namespace Speciphy\Framework\Recorder;

class CamelCaseNameFormatter
{
    function format($name)
    {
        return str_replace("_", " ", $name);
    }
}


