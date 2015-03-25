<?php

use Speciphy\Framework\ContextBuilder;
use Hamcrest\Matcher;

class IsMethod implements Matcher
{
    function __construct($method)
    {
        $this->method = $method;
    }

    function describeTo(Hamcrest\Description $description)
    {
        $this->desc($description, $this->method);
    }

    function matches($subject)
    {
        return ($subject instanceof \ReflectionMethod) &&
               ($subject->class == $this->method->class) &&
               ($subject->name == $this->method->name);  
    }

    function describeMismatch($subject, Hamcrest\Description $description)
    {
        $this->desc($description, $subject);
    }

    function desc($description, $method)
    {
        $description->appendText("method ".$method->class . "::" . $method->name);
    }
}

function isMethod($m){ return new IsMethod($m); }

class this_is_not_a_context
{

    function it_should_find_this_one()
    {
    }

    /**
    *@assertion
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

    function it_should_not_find_methods_annotated_with_ignore()
    {
        $cls = new \ReflectionClass(this_is_not_a_context::class);
        $method = $cls->getMethod("it_should_ignore_this_one");
        expect($this->context->then, not(hasValue(isMethod($method))));
    }
}
