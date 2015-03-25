# speciphy
Simple context/specification style testing for PHP, inspired by [mspec](https://github.com/machine/machine.specifications) and the wonderful [contexts](https://github.com/benjamin-hodgson/Contexts)

## Does it work yet?

No. But putting it up on github makes me feel a sense of urgency in finishing it.

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

## How does it know what my methods are intended to do?

Speciphy uses a simple keyword-based approach to finding contexts and assertions, with annotations for those hard-to-reach areas:

* A class starting with the word "when" (or annotated with @context) is a test.
* A function starting with the word "given" (or annotated with @arrange) is a setup method.
* A function containing the word "when", or "because" (or annotated @act) is an action method.
* A function containing the word "should" (or annotated @assert) is an assertion.

## Can I change the matching?

You can change the behaviour of the runner by replacing the rules it uses for matching tests.
You can introduce your own assertion matchers by implementing a class that's compatible with [Hamcrest's BaseMatcher](https://github.com/hamcrest/hamcrest-php/blob/master/hamcrest/Hamcrest/BaseMatcher.php)
