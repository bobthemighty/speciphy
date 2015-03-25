<?php

use Speciphy\Framework\ContextSelector;

class When_a_class_starts_with_the_word_when
{
    function given_a_context_selector()
    {
        $this->selector = new ContextSelector();
    }

    function because_we_filter_for_contexts()
    {
        $this->result = $this->selector->select( array(static::class) );
    }

    function this_class_should_be_included()
    {
        expect($this->result, hasValue(static::class));
    }
}

/**
 * @context
 **/
class ClassesThatAreMarkedWithContextAreContexts
{
    function given_a_context_selector()
    {
        $this->selector = new ContextSelector();
    }

    function because_we_filter_for_contexts()
    {
        $this->result = $this->selector->select( array(static::class) );
    }

    function this_class_should_be_included()
    {
        expect($this->result, hasValue(static::class));
    }
}

class UnrelatedHelperClass
{
}

class When_selecting_contexts_from_an_array
{
    function given_an_array_of_classes()
    {
        $this->candidates = [
            When_a_class_starts_with_the_word_when::class,
            UnrelatedHelperClass::class,
            ClassesThatAreMarkedWithContextAreContexts::class,
            ];
    }

    function because_we_select_contexts_from_the_candidates()
    {
       $selector = new ContextSelector();
       $this->contexts = $selector->select($this->candidates);
    }

    function we_should_not_select_an_unrelated_helper_class()
    {
        expect($this->contexts, not(hasValue(UnrelatedHelperClass::class)));
    }

    function we_should_select_a_class_starting_with_when()
    {
        expect($this->contexts, hasValue(When_a_class_starts_with_the_word_when::class));
    }

    function we_should_select_a_class_if_it_is_explicitly_marked_as_a_context()
    {
        expect($this->contexts, hasValue(ClassesThatAreMarkedWithContextAreContexts::class));
    }
}

