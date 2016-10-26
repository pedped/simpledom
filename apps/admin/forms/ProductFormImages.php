<?php

use Phalcon\Forms\Element\Submit;
use Simpledom\Core\AtaForm;

class ProductFormImages extends AtaForm {

    public function initialize() {


        // ّFile
        $id = new FileElement('file');
        $id->setLabel('تصویر');
        $this->add($id);



        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute("label", "ارسال");
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
