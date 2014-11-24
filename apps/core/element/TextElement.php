<?php

use Phalcon\Forms\Element\Text;

/**
 * Uses
 */
class TextElement extends Text {

    protected $footer;
    protected $info;
    protected $icon;

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

    public function getIcon() {
        return $this->icon;
    }

    /**
     * 
     * @param type $icon
     * @return TextElement
     */
    public function setIcon($icon) {
        $this->icon = $icon;
        return $this;
    }

    public function render($attributes = null) {

        $elementName = $this->getName();
        $icon = $this->getIcon();
        $attributes = $this->getAttributes();
        $attributesValue = "";
        foreach ($attributes as $key => $atv) {
            $attributesValue .= " $key='$atv'";
        }

        if (isset($icon)) {
            $result = "";
            $result.= "<div class='input-group'>";
            $result.= "<input type='text' name='$elementName' id='$elementName' $attributesValue />";
            $result.= "<span class='input-group-addon'><span class='$icon'></span></span>";
            $result.= "</div>";
            return $result;
        } else {
            return "<input type='text' name='$elementName' id='$elementName' $attributesValue />";
        }
    }

}
