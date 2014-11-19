<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class SendMoshaverAnswerForm extends AtaForm {

    public function initialize() {

        // Address
        $answer = new TextAreaElement('answer');
        //$address->setAttribute('placeholder', 'Enter your Address');
        $answer->setAttribute('class', 'form-control');
        $answer->setAttribute('rows', '10');
        $answer->addValidator(new PresenceOf(array(
        )));
        $this->add($answer);


        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('value', 'ارسال');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
