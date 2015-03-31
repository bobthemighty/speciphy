<?php

use mindplay\annotations\AnnotationCache;
use mindplay\annotations\Annotations;

Annotations::$config['cache'] = new AnnotationCache(sys_get_temp_dir());
Annotations::getManager()->registry["context"] = "Speciphy\Framework\Annotations\ContextAnnotation";
Annotations::getManager()->registry["assert"] = "Speciphy\Framework\Annotations\AssertionAnnotation";
Annotations::getManager()->registry["arrange"] = "Speciphy\Framework\Annotations\SetupAnnotation";
Annotations::getManager()->registry["nospec"] = "Speciphy\Framework\Annotations\IgnoreAnnotation";
Annotations::getManager()->registry["act"] = "Speciphy\Framework\Annotations\ActAnnotation";
