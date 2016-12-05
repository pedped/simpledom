<?php

use Simpledom\Core\Classes\Config;

/**
 * 
 * https://github.com/aehlke/tag-it
 */
class ProductSelectElement extends TagEditElement {

    public function __construct($name, $attributes = null) {
        parent::__construct($name, $attributes);
        
        $this->setAutocompleteSource(Config::getPublicUrl() . "/admin/api/listproducts");
        $this->setAttribute('class', 'form-control');
    }

}
