<?php

use Speciphy\Framework\ContextBuilder;

class When_a_method_name_contains_the_word_given
{
    function given_a_builder_and_a_class()
    {
        $this->builder = new ContextBuilder();
        $this->cls = new \ReflectionClass(static::class);
    }

    function because_we_build_a_context()
    {
        $this->ctx = $this->builder->build($this->cls);
    }

    function it_should_select_the_method()
    {
        expect($this->ctx->given,
            isMethod($this->cls->getMethod("given_a_builder_and_a_class")));
    }
}

class When_a_method_name_contains_the_word_setup
{
    function setup_a_builder_and_a_class()
    {
        $this->builder = new ContextBuilder();
        $this->cls = new \ReflectionClass(static::class);
    }

    function because_we_build_a_context()
    {
        $this->ctx = $this->builder->build($this->cls);
    }

    function it_should_select_the_method()
    {
        expect($this->ctx->given,
            isMethod($this->cls->getMethod("setup_a_builder_and_a_class")));
    }

}

class When_a_method_name_contains_the_word_establish
{
}

class When_a_method_is_annotated_as_setup
{
}

class When_a_setup_method_is_decorated_with_nospec
{
}
