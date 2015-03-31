<?php

use Speciphy\Framework\ContextBuilder;

class When_a_method_begins_when
{
    function given_a_context_builder()
    {
        $this->builder = new ContextBuilder();
        $this->cls = new \ReflectionClass(static::class);
    }

    function when_the_context_is_built()
    {
        $this->context = $this->builder->build($this->cls);
    }

    function it_should_select_the_method()
    {
        expect( 
            $this->context->action,
            isMethod($this->cls->getMethod("when_the_context_is_built"))
        );
    }
}

class When_a_method_begins_because
{
    function given_a_context_builder()
    {
       $this->builder = new ContextBuilder();
       $this->cls = new \ReflectionClass(static::class);
    }

    function because_the_context_is_built()
    {
        $this->context = $this->builder->build($this->cls);
    }

    function it_should_select_the_method(){
     expect( 
            $this->context->action,
            isMethod($this->cls->getMethod("because_the_context_is_built"))
        );
    }
}

class When_an_action_is_marked_nospec
{
    function given_a_context_builder()
    {
       $this->builder = new ContextBuilder();
       $this->cls = new \ReflectionClass(static::class);
    }

    /**
    * @nospec
    */   
    function because_the_context_is_built()
    {
    }

    function it_should_select_the_method(){
        $this->context = $this->builder->build($this->cls);

        expect( 
            $this->context->action,
            is( nullvalue() )
        );
    }

}

class When_a_method_is_annotated_as_an_action{
 
    function given_a_context_builder()
    {
       $this->builder = new ContextBuilder();
       $this->cls = new \ReflectionClass(static::class);
    }

    /**
     * @act
     */
    function FurbachtNeepleWom()
    {
        $this->context = $this->builder->build($this->cls);
    }

    function it_should_select_the_method()
    {
        expect( 
            $this->context->action,
            isMethod($this->cls->getMethod("FurbachtNeepleWom"))
        );

    }
}
