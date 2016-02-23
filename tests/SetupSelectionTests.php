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

    function establish_we_have_a_builder_and_a_class()
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
            isMethod($this->cls->getMethod("establish_we_have_a_builder_and_a_class")));
    }

}

class When_a_method_is_annotated_as_setup
{
    /**
     * @arrange
     */  
    function foobarbaz()
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
            isMethod($this->cls->getMethod("foobarbaz")));
    }

}

class When_a_setup_method_is_decorated_with_nospec
{
    /**
    * @nospec
    */
    function given_a_method_that_should_not_be_called()
    {
      throw new Exception("#Fail");
    }

    function because_we_build_a_context()
    {
        $cls = new \ReflectionClass(static::class);
        $ctxbuilder = new ContextBuilder();
        $this->ctx = $ctxbuilder->build($cls);
    }

    function it_should_not_be_selected()
    {
        expect($this->ctx->given,
            is( nullvalue() ));
    }
}

class parent_class
{
    function given_a_parent_class_with_an_arrangement_method()
    {
    }
}

class When_a_class_inherits_an_arrangement_method extends parent_class
{
    
    function because_we_build_a_context()
    {
        $this->cls = new \ReflectionClass("parent_class");
        $ctxbuilder = new ContextBuilder();
        $this->ctx = $ctxbuilder->build($this->cls);
    }

    function it_should_select_the_arrangement()
    {
        expect($this->ctx->given,
            isMethod($this->cls->getMethod("given_a_parent_class_with_an_arrangement_method")));
    }
}
