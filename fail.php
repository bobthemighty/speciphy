<?php

include_once "framework.php";

class When_asserting_ludicrous_things
{
    function zero_should_equal_one(){
        expect(0)
            ->to
            ->equal(1);
    }
}

