# speciphy
Simple context/specification style testing for PHP, inspired by [mspec](https://github.com/machine/machine.specifications) and the wonderful [contexts](https://github.com/benjamin-hodgson/Contexts)

## Does it work yet?

Yes! Packages are coming soon, but right now you can build your own phar using [box](https://github.com/box-project/box2).

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
* A function containing the word "should", or "will" (or annotated @assert) is an assertion.

## Can I change the matching?

You can change the behaviour of the runner by replacing the rules it uses for matching tests.
You can introduce your own assertion matchers by implementing a class that's compatible with [Hamcrest's BaseMatcher](https://github.com/hamcrest/hamcrest-php/blob/master/hamcrest/Hamcrest/BaseMatcher.php)


## StackTest.php example

``` php

class When_adding_an_element_to_an_empty_stack
{
    function given_an_empty_stack()
    {
        $this->stack = new Stack();
    }

    function because_we_push_an_item()
    {
        $this->stack.Push("foo");
    }

    function it_should_have_length_1()
    {
        expect($this->stack.length, equal_to(1));
    }

    function it_should_have_the_item_as_its_topmost_element()
    {
        expect($this->stack.Peek(), equal_to("foo"));
    }
}


class When_popping_an_empty_stack
{

    function given_an_empty_stack()
    {
        $this->stack = new Stack();
    }

    function popping_the_stack_should_throw
    {
        expect(
            function(){
                $this->stack.Pop()
            },
           throws()    
        );
    }
}

class When_popping_from_a_non_empty_stack
{
    function given_a_non_empty_stack()
    {
        $this->stack = new Stack(["foo"]);
    }

    function because_we_pop_the_item()
    {
        $this->result = $this->stack.Pop();
    }

    function it_should_return_the_popped_item()
    {
        expect($this->result, equal_to("foo"));
    }

    function it_should_decrement_the_length()
    {
        expect($this->stack->length, equal_to(0));
    }
}

```


