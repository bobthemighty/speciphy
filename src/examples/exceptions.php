<?php

class When_testing_exceptions
{

    function throws(){ throw Exception(); }
 
    function it_should_throw_when_called()
    {
  
        expect(should_throw)
            -> to
            -> throw_exception();
   } 
}
