<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class SendPermissionForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // User Post From
        $userpost1 = new TextElement('userpost1');
        $userpost1->setLabel('User Post From');
        //$userpost1->setAttribute('placeholder', 'Enter your User Post From');
        $userpost1->setAttribute('class', 'form-control');
        $userpost1->addValidator(new PresenceOf(array(
        )));
        $this->add($userpost1);


        // User Post To
        $userpost2 = new TextElement('userpost2');
        $userpost2->setLabel('User Post To');
        //$userpost2->setAttribute('placeholder', 'Enter your User Post To');
        $userpost2->setAttribute('class', 'form-control');
        $userpost2->addValidator(new PresenceOf(array(
        )));
        $this->add($userpost2);


        // Can Send
        $cansend = new EnableDisableElement('cansend');
        $cansend->setLabel('Can Send');
        //$cansend->setAttribute('placeholder', 'Enter your Can Send');
        $cansend->setAttribute('class', 'form-control');
        $cansend->addValidator(new PresenceOf(array(
        )));
        $this->add($cansend);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
