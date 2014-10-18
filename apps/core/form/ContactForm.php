<?php

namespace Simpledom\Core;

use EditorElement;
use MapElement;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Settings;

class ContactForm extends AtaForm {

    public function initialize() {

        // First Name
        $name = new Text("name");
        $name->setLabel("Full Name");
        //$name->setAttribute("placeholder", "Enter your Full Name");
        $name->setAttribute("class", "form-control");
        $name->addValidator(new PresenceOf(array(
            'message' => 'The name is required'
        )));
        $name->addValidator(new StringLength(array(
            'min' => 6,
            'messageMinimum' => 'The name is too short'
        )));
        $this->add($name);

        // ٍEmail
        $email = new Text("email");
        $email->setLabel("Email");
        //$email->setAttribute("placeholder", "Enter Email");
        $email->setAttribute("class", "form-control");
        $email->addValidator(new PresenceOf(array(
            'message' => 'The email is required'
        )));
        $email->addValidator(new Email(array(
            'message' => 'please enter a valid email'
        )));
        $this->add($email);


        // Section
        $reason = new Select("section", array(
            'support' => 'Support',
            'sale' => 'Sale',
            'reseller' => 'Resseler'
        ));
        $reason->setLabel("Section");
        $reason->setAttribute("class", "form-control");
        $this->add($reason);


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
        $message->setLanguage("en");
        $this->add($message);


        $settins = Settings::Get();

        // Map
        $map = new MapElement("map");
        $map->setLabel("Our Location");
        $map->setLanguage("en");
        $map->setMarkTitle("Findout Us");
        $map->setMarkDescription("About Us");
        $map->setLathitude($settins->latitude);
        $map->setLongtude($settins->longtude);
        $map->setZoom(12);
        $this->add($map);

        // Submit Button
        $submit = new Submit("submit");
        $submit->setName("submit");
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
