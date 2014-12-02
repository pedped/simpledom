<?php

use Phalcon\Forms\Element\Check;

/**
 * Uses
 */
class EnableDisableElement extends Check {
    public function __construct($name, $attributes=null) {
        parent::__construct($name, $attributes);
        $this->setAttributes(array(
            "class" => "switch-checkbox",
            "data-on-text" => "بله",
            "data-off-text" => "خیر"
        ));
    }
}
