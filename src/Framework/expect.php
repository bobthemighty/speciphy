<?php

use Hamcrest\StringDescription;

function expect($subject, $matcher)
{
    $desc = new StringDescription();
    if($matcher->matches($subject))
    {
        return;
    }
    $desc->appendText("Expected ");
    $desc->appendDescriptionOf($matcher);
    $desc->appendText(" but was ");

    $matcher->describeMismatch($subject,$desc);
    throw new Exception($desc->__toString());
}



