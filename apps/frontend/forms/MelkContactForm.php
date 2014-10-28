<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Simpledom\Core\AtaForm;

class MelkContactForm extends AtaForm {

    public function initialize() {

        // First Name
        $name = new TextElement("name");
        $name->setLabel(_("Full Name"));
        $name->setAttribute("class", "form-control");
        $name->addValidator(new PresenceOf(array(
        )));
        $name->addValidator(new StringLength(array(
            'min' => 6,
        )));
        $this->add($name);

        // Phone
        $phone = new Text("phone");
        $phone->setLabel(_("Phone"));
        $phone->setAttribute("class", "form-control");
        $phone->addValidator(new PresenceOf(array(
        )));
        $this->add($phone);

        // message
        $message = new TextArea("message");
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
