<?php


include_once "framework.php";

class When_asserting_truth
{
    function given_the_value_true()
    {
        $this->val = true; 
    }

   function it_should_be_true() {
       expect($this->val)
           ->to
           ->be_true();
   }

    function it_should_not_be_false() {
        expect($this->val)
            ->to_not
            ->be_false();
    }

    function it_should_equal_true() {
        expect($this->val)
            ->to
            ->equal(true);
    }

    function it_should_not_equal_false() {
        expect($this->val)
            ->to_not
            ->equal(false);
    }
}
