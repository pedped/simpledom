<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class AnswerForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Question ID
        $questionid = new TextElement('questionid');
        $questionid->setLabel('Question ID');
        //$questionid->setAttribute('placeholder', 'Enter your Question ID');
        $questionid->setAttribute('class', 'form-control');
        $questionid->addValidator(new PresenceOf(array(
        )));
        $this->add($questionid);


        // User ID
        $userid = new TextElement('userid');
        $userid->setLabel('User ID');
        //$userid->setAttribute('placeholder', 'Enter your User ID');
        $userid->setAttribute('class', 'form-control');
        $userid->addValidator(new PresenceOf(array(
        )));
        $this->add($userid);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);


        // Message
        $message = new TextAreaElement('message');
        $message->setLabel('Message');
        //$message->setAttribute('placeholder', 'Enter your Message');
        $message->setAttribute('class', 'form-control');
        $message->addValidator(new PresenceOf(array(
        )));
        $this->add($message);


        // Delete
        $delete = new EnableDisableElement('delete');
        $delete->setLabel('Delete');
        //$delete->setAttribute('placeholder', 'Enter your Delete');
        $delete->setAttribute('class', 'form-control');
        $delete->addValidator(new PresenceOf(array(
        )));
        $this->add($delete);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
