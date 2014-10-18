<?php

namespace Simpledom\Core;

use EditorElement;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class SendBulkEmailForm extends AtaForm {

    public function initialize() {

        // From
        $from = new Text("from");
        $from->setLabel("From");
        //$from->setAttribute("placeholder", "Enter your Full Name");
        $from->setAttribute("class", "form-control");
        $from->addValidator(new PresenceOf(array(
            'message' => 'The from is required'
        )));
        $from->addValidator(new StringLength(array(
            'min' => 6,
            'messageMinimum' => 'The from is too short'
        )));
        $this->add($from);


        // From
        $subject = new Text("subject");
        $subject->setLabel("Subject");
        //$subject->setAttribute("placeholder", "Enter your Full Name");
        $subject->setAttribute("class", "form-control");
        $subject->setAttribute("height", "200px");
        $subject->addValidator(new PresenceOf(array(
            'message' => 'The subject is required'
        )));
        $subject->addValidator(new StringLength(array(
            'min' => 6,
            'messageMinimum' => 'The subject is too short'
        )));
        $this->add($subject);


        // Message
        $message = new EditorElement("message");
        $message->setLabel("Message");
        $message->setAttribute("class", "form-control");
        $message->addValidator(new PresenceOf(array(
            'message' => 'The message is required'
        )));
        $message->addValidator(new StringLength(array(
            'min' => 10,
            'messageMinimum' => 'The message is too short'
        )));
        $this->add($message);


        // Submit Button
        $submit = new Submit("submit");
        $submit->setName("submit");
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
