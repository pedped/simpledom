<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class ProductGalleryForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Product ID
        $product_id = new TextElement('product_id');
        $product_id->setLabel('Product ID');
        //$product_id->setAttribute('placeholder', 'Enter your Product ID');
        $product_id->setAttribute('class', 'form-control');
        $product_id->addValidator(new PresenceOf(array(
        )));
        $this->add($product_id);


        // Image ID
        $imageid = new TextElement('imageid');
        $imageid->setLabel('Image ID');
        //$imageid->setAttribute('placeholder', 'Enter your Image ID');
        $imageid->setAttribute('class', 'form-control');
        $imageid->addValidator(new PresenceOf(array(
        )));
        $this->add($imageid);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}