<?php

use Phalcon\Forms\Element\Submit;
use Simpledom\Core\AtaForm;

class ProductFormVoice extends AtaForm {

    public function initialize() {


        // ّFile
        $id = new FileElement('file');
        $id->setLabel('فایل صوتی');
        $this->add($id);


        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute("label", "ارسال");
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
