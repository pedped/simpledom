<?php

use Phalcon\Forms\Element;

abstract class BaseElement extends Element {

    protected $footer;
    protected $info;
    protected $scriptnames = array();
    protected $externalScriptNames = array();
    protected $cssnames = array();
    protected $externalCSS = array();

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

    public function getScriptnames() {
        return $this->scriptnames;
    }

    public function setScriptnames($scriptnames) {
        $this->scriptnames = $scriptnames;
        return $this;
    }

    public function getCssnames() {
        return $this->cssnames;
    }

    public function setCssnames($cssnames) {
        $this->cssnames = $cssnames;
        return $this;
    }

    public function getExternalScriptNames() {
        return $this->externalScriptNames;
    }

    public function getExternalCSS() {
        return $this->externalCSS;
    }

    public function setExternalScriptNames($externalScriptNames) {
        $this->externalScriptNames = $externalScriptNames;
        return $this;
    }

    public function setExternalCSS($externalCSS) {
        $this->externalCSS = $externalCSS;
        return $this;
    }

}
