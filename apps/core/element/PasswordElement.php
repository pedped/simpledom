<?php

use Phalcon\Forms\Element\Password;

/**
 * Uses
 */
class PasswordElement extends Password {

    protected $footer;
    protected $info;

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
