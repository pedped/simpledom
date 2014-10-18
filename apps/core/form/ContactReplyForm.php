<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class ContactReplyForm extends AtaForm {

    public function initialize() {

        // Message
        $message = new TextArea("message");
        $message->setLabel("Message");
        $message->setAttribute("class", "form-control");
        $message->addValidator(new PresenceOf(array(
            'message' => 'The message is required'
        )));
        $message->addValidator(new StringLength(array(
            'min' => 32,
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
