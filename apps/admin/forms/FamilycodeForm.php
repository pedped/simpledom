<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class FamilycodeForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Code
        $code = new TextElement('code');
        $code->setLabel('رمز خانوار');
        //$code->setAttribute('placeholder', 'Enter your Code');
        $code->setAttribute('class', 'form-control');
        $code->addValidator(new PresenceOf(array(
        )));
        $this->add($code);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
