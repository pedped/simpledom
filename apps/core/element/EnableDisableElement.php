<?php

use Phalcon\Forms\Element\Select;

/**
 * Uses
 */
class EnableDisableElement extends Select {

    protected $footer;
    protected $info;

    public function __construct($name, $options = null, $attributes = null) {
        parent::__construct($name, $options, $attributes);
        $this->setOptions(array(
            "1" => "Yes",
            "0" => "No"
        ));
    }

    public function getFooter() {
        return $this->footer;
    }

    public function getInfo() {
        return $this->info;
    }

    public function setFooter($footer) {
        $this->footer = $footer;
        return $this;
    }

    public function setInfo($info) {
        $this->info = $info;
        return $this;
    }

}
