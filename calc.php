<?php

include_once "framework.php";

class Calculator
{
    function add($a, $b)
    {
        return $a + $b;
    }
}

class When_adding_two_numbers
{
    function given_a_calculator()
    {
        $this->calc = new Calculator();
    }

    function when_we_add_two_numbers()
    {
        $this->result = $this->calc->add(1, 2);
    }

    function it_should_have_the_correct_result()
    {
        expect($this->result)
            ->to
            ->equal(3);
    }
}
