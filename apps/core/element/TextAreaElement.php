<?php

use Phalcon\Forms\Element\TextArea;

/**
 * Uses
 */
class TextAreaElement extends TextArea {

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
