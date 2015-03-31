<?php

use Speciphy\Framework\ContextBuilder;
use Hamcrest\Matcher;

class this_is_not_a_context
{

    function it_should_find_this_one()
    {
    }

    /**
    *@assert
    */
    function andThis(){}

    
    /**
    *@nospec
    */ 
    function it_should_ignore_this_one(){}
}

class When_filtering_a_context_for_assertions
{
    function given_a_context_builder()
    {
        $this->builder = new ContextBuilder();
    }

    function because_we_build_a_context()
    {
        $cls = new \ReflectionClass(this_is_not_a_context::class);
        $this->context = $this->builder->build($cls);
    }

    function it_should_find_methods_containing_the_word_it()
    {
        $cls = new \ReflectionClass(this_is_not_a_context::class);
        $method = $cls->getMethod("it_should_find_this_one");
        expect($this->context->then, hasValue(isMethod($method)));
    }

    function it_should_not_find_methods_annotated_with_nospec()
    {
        $cls = new \ReflectionClass(this_is_not_a_context::class);
        $method = $cls->getMethod("it_should_ignore_this_one");
        expect($this->context->then, not(hasValue(isMethod($method))));
    }
    
    function it_should_find_methods_annotated_with_assertion()
    {
        $cls = new \ReflectionClass(this_is_not_a_context::class);
        $method = $cls->getMethod("andThis");
        expect($this->context->then, hasValue(isMethod($method)));
    }
}
