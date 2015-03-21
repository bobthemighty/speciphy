<?php

include_once "framework.php";

$shiz = get_declared_classes();
include_once $argv[1];
$new_shiz = array_diff(get_declared_classes(), $shiz);


foreach($new_shiz as $t)
{
    if(is_context($t)) {
         $cls = new ReflectionClass($t);
         $methods = $cls->getMethods();
         $foo = array_filter($methods, 'is_action');
         $ctx = new Context($cls,
             reset(array_filter($methods, 'is_setup')),
             reset(array_filter($methods, 'is_action')),
             array_filter($methods, 'is_assert'));

         $ctx->execute()->report();
    }
}
