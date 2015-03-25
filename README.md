# speciphy
Simple context/specification style testing for PHP, inspired by mspec and contexts

## What does it do?

Speciphy gives you simple given/when/then style testing in PHP. It uses Hamcrest-php for matching, so that you get useful error messages.

## How do I use it?

``` php

class When_I_write_a_test_class_starting_with_when
{
    function given_some_setup_code()
    {
       $this-> calculator = new Calculator(1);
    }
    
    function when_the_action_is_run()
    {
       $this->calculator->add(2);
    }
    
    function it_will_execute_assertions()
    {
        expect($this->calculator->result, 
          is(equalTo(3)));
    }
}
```
