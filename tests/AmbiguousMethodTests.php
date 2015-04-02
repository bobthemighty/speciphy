<?php

use Speciphy\Framework\ContextBuilder;

class ThisIsNotAContext
{
    function when_a_method_is_ambiguous_because_it_contains_keywords_that_are_setup_to_be_given_multiple_meanings_it_should_not_build()
    {
    }
}

class When_a_method_name_is_ambiguous
{
    function given_a_builder()
    {
       $this->builder = new ContextBuilder();
       $this->cls = new \ReflectionClass('ThisIsNotAContext');
    }

    function it_should_throw_ambiguous_method()
    {
        expect(
            function(){
                $this->builder->build($this->cls);
            },
          throws());
    }
}
