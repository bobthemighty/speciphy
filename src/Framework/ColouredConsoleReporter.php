<?php

namespace Speciphy\Framework;

use Speciphy\Framework\Recorder\TestRunRecorder;

class ColouredConsoleReporter implements TestRunRecorder
{
    function report($result)
    {
        if($result->is_successful())
        {
            error_log(Color::set($result->contextName, "green+bold+underline"));
        }
        else
        {
            error_log(Color::set($result->contextName, "red+bold+underline"));
        }

        if($result->setup)
        {
            error_log(Color::set("* ". $result->setup, "bold+white"));
        }

        if($result->action)
        {
            error_log(Color::set("* ". $result->action, "bold+white"));
        }

        foreach($result->asserts as $assert)
        {
            if($assert->success) 
            {
                error_log(Color::set("\t* ". $assert->name, "white"));
            }
            else
            {
                error_log(Color::set("\t* ". $assert->name, "red"));
                error_log(Color::set("\t** ". $assert->msg, "yellow"));
            }
        }
    }
}
