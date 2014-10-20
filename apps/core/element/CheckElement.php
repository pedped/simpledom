<?php

use Phalcon\Forms\Element\Check;

/**
 * Uses
 */
class CheckElement extends Check {

    protected $footer;
    protected $info;
    protected $checkboxText;

    public function getCheckboxText() {
        return $this->checkboxText;
    }

    public function setCheckboxText($checkboxText) {
        $this->checkboxText = $checkboxText;
        return $this;
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

    public function render($attributes = null) {

        $attrText = "";
        if (isset($this->_attributes) && is_array($this->_attributes)) {
            $attributes = $this->_attributes;
            $aitems = array();
            foreach ($attributes as $key => $value) {
                $aitems[] = "$key='$value'";
            }
            $attrText = implode(" ", $aitems);
        }


        $label = $this->getCheckboxText();
        $name = $this->getName();
        $html = "<label  for='$name'>
            <input name='$name' type='checkbox' $attrText>
            $label
            </label>";
        return $html;
    }

}
