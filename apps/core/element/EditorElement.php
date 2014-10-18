<?php

/**
 * Uses CKEDITOR
 */
class EditorElement extends BaseElement {

    private $language = "en";

    public function __construct($name, $attributes = null) {
        parent::__construct($name, $attributes);

        // we have to add the javascript and css for the item
        $this->setScriptnames(array(
            "ckeditor/ckeditor.js"
        ));
    }

    public function getLanguage() {
        return $this->language;
    }

    public function setLanguage($language = "en") {
        $this->language = $language;
    }

    public function render($attributes = null) {
        $name = $this->getName();
        $text = $this->getDefault();
        $html = "
            <textarea name='$name' id='$name' rows='10' cols='80'>
                $text
            </textarea>
            <script>
                CKEDITOR.replace( '$name' , {
                    language: '$this->language'
} );
            </script>
            ";
        return $html;
    }

}
