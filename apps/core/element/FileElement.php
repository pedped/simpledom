<?php

use Phalcon\Forms\Element\File;

/**
 * Uses
 */
class FileElement extends File {

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
