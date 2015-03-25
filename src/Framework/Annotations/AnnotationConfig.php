<?php

use mindplay\annotations\AnnotationCache;
use mindplay\annotations\Annotations;

Annotations::$config['cache'] = new AnnotationCache(sys_get_temp_dir());
Annotations::getManager()->registry["context"] = "Speciphy\Framework\Annotations\ContextAnnotation";
Annotations::getManager()->registry["assertion"] = "Speciphy\Framework\Annotations\AssertionAnnotation";
