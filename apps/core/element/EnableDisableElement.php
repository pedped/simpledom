<?php

/**
 * Uses
 */
class EnableDisableElement extends BaseElement {

    public function __construct($name, $attributes = null) {
        parent::__construct($name, $attributes);

        $this->setScriptnames(array(
            "js/bootstrap-switch.min.js"
        ));

        $this->setCssnames(array(
            "css/bt3/bootstrap-switch.min.css"
        ));

    }

    public function render($attributes = null) {
        $elementName = $this->getName();
        $default = $this->getDefault();
        $html = "<input type='checkbox' data-on-text='بله' data-off-text='خیر' name='$elementName' id='$elementName' value='1' class='switch-checkbox' checked='$default' />";
        $html .= "<script> $(document).ready(function() { $('#" . $elementName . "').bootstrapSwitch()}); </script>";
        return $html;
    }

}
