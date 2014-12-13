<?php

/**
 * 
 * https://github.com/aehlke/tag-it
 */
class TagEditElement extends BaseElement {

    protected $autocompleteSource = "";
    protected $allowSpaces = true;
    protected $readOnly = false;
    protected $tagLimit = 500;
    protected $singleField = false;
    protected $placeholderText = null;
    protected $singleFieldDelimiter = ",";

    public function getAutocompleteSource() {
        return $this->autocompleteSource;
    }

    public function getReadOnly() {
        return $this->readOnly ? "true" : "false";
    }

    public function getTagLimit() {
        return $this->tagLimit;
    }

    public function getSingleField() {
        return $this->singleField ? "true" : "false";
    }

    public function getPlaceholderText() {
        return isset($this->placeholderText) && strlen($this->placeholderText) > 0 ? "'$this->placeholderText'" : "''";
    }

    public function getSingleFieldDelimiter() {
        return $this->singleFieldDelimiter;
    }

    public function setSingleFieldDelimiter($singleFieldDelimiter) {
        $this->singleFieldDelimiter = $singleFieldDelimiter;
        return $this;
    }

    public function setAutocompleteSource($autocompleteSource) {
        $this->autocompleteSource = $autocompleteSource;
        return $this;
    }

    public function setReadOnly($readOnly) {
        $this->readOnly = $readOnly;
        return $this;
    }

    public function setTagLimit($tagLimit) {
        $this->tagLimit = $tagLimit;
        return $this;
    }

    public function setSingleField($singleField) {
        $this->singleField = $singleField;
        return $this;
    }

    public function setPlaceholderText($placeholderText) {
        $this->placeholderText = $placeholderText;
        return $this;
    }

    public function getAllowSpaces() {
        return $this->allowSpaces ? "true" : 'false';
    }

    /**
     * 
     * @param boolean $allowSpaces
     * @return TagEditElement
     */
    public function setAllowSpaces($allowSpaces) {
        $this->allowSpaces = $allowSpaces;
        return $this;
    }

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
            "jquery-ui/jquery-ui.min.js",
            "jquery-tagit/js/tag-it.min.js",
        ));
        $this->setCssnames(array(
            "jquery-ui/jquery-ui.min.css",
            "jquery-tagit/css/jquery.tagit.css",
        ));
    }

    public function render($attributes = null) {

        $defaults = $this->getDefault();
        $allowSpaces = $this->getAllowSpaces();
        $autoCompleteSource = $this->autocompleteSource;

        $name = $this->getName();
        $html = "<input type='text' name='$name' id='$name' class='form-control' value='$defaults' />"
                . "\n<script>"
                . "$('#$name').tagit({
                        allowSpaces : $allowSpaces,
                        taglimit : " . $this->getTagLimit() . ",
                        singlefield : " . $this->getSingleField() . ",
                        placeholdertext : " . $this->getPlaceholderText() . ",
                        singleFieldDelimiter : " . $this->getSingleFieldDelimiter() . ",
                  ";


        if (isset($autoCompleteSource) && strlen($autoCompleteSource) > 0) {
            $html .= "autocomplete : {"
                    . "delay: 0, minLength: 2,"
                    . "source : $autoCompleteSource"
                    . "}";
        }

        $html .= "});"
                . "</script>";
        return $html;
    }

}
