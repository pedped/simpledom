<?php

/**
 * 
 * Uses CKEDITOR
 */
class TagEditElement extends BaseElement {

    protected $source = "['Amsterdam', 'Washington', 'Sydney', 'Beijing', 'Cairo']";
    protected $itemText = "'label'";
    protected $itemValue = "'id'";

    public function getItemText() {
        return $this->itemText;
    }

    public function getItemValue() {
        return $this->itemValue;
    }

    public function getSource() {
        return $this->source;
    }

    /**
     *    function(item) {
     *        return item.label;
     *     }
     * @param type $itemText
     * @return TagEditElement
     */
    public function setItemText($itemText) {
        $this->itemText = $itemText;
        return $this;
    }

    /**
     *    function(item) {
     *        return item.id;
     *     }
     * @param type $itemValue
     * @return TagEditElement
     */
    public function setItemValue($itemValue) {
        $this->itemValue = $itemValue;
        return $this;
    }

    /**
     * set source
     * @param type $source
     * @return TagEditElement
     */
    public function setSource($source) {
        $this->source = $source;
        return $this;
    }

    public function __construct($name, $attributes = null) {
        parent::__construct($name, $attributes);

        // we have to add the javascript and css for the item
        $this->setScriptnames(array(
            "js/bootstrap-tagsinput/bootstrap-tagsinput.js"
        ));
        $this->setCssnames(array(
            "js/bootstrap-tagsinput/bootstrap-tagsinput.css"
        ));
    }

    public function render($attributes = null) {

        $name = $this->getName();
        $html = "<input type='text' name='$name' id='$name' class='form-control' />"
                . "\n<script>"
                . "$('#$name').tagsinput({
                        tagClass : function(item) {
                            return (item.length > 10 ? 'small' : 'small');
                        }
                      });"
                . "</script>";
        return $html;
    }

}
