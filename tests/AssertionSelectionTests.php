<?php

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
    *@ignore
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
        $cls = new ReflectedClass(this_is_not_a_context::class);
        $context = $this->builder->build($cls);
    }

    function it_should_find_methods_containing_the_word_it()
    {
    }
}
