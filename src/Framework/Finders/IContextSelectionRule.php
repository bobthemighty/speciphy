<?php

namespace Speciphy\Framework\Finders;

interface IContextSelectionRule{
    public function isContext($class);
}

