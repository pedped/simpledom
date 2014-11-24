<?php

namespace Simpledom\Core;

use EditorElement;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use TextElement;

class SendBulkEmailForm extends AtaForm {

    public function initialize() {

        // From
        $from = new TextElement("from");
        $from->setLabel(_("From"));
        //$from->setAttribute("placeholder", "Enter your Full Name");
        $from->setAttribute("class", "form-control");
        $from->addValidator(new PresenceOf(array(
        )));
        $from->addValidator(new StringLength(array(
            'min' => 6,
        )));
        $this->add($from);


        // From
        $subject = new TextElement("subject");
        $subject->setLabel(_("Subject"));
        //$subject->setAttribute("placeholder", "Enter your Full Name");
        $subject->setAttribute("class", "form-control");
        $subject->setAttribute("height", "200px");
        $subject->addValidator(new PresenceOf(array(
        )));
        $subject->addValidator(new StringLength(array(
            'min' => 6,
        )));
        $this->add($subject);


        // Message
        $message = new EditorElement("message");
        $message->setLabel(_("Message"));
        $message->setAttribute("class", "form-control");
        $message->addValidator(new PresenceOf(array(
        )));
        $message->addValidator(new StringLength(array(
            'min' => 10,
        )));
        $this->add($message);


        // Submit Button
        $submit = new Submit("submit");
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
