<?php

use Hamcrest\StringDescription;

class ExpectationException extends \RuntimeException
{
}

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
    throw new ExpectationException($desc->__toString());
}



