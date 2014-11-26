<?php

namespace Simpledom\Core;

use MapElement;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Settings;
use TextAreaElement;
use TextElement;

class ContactForm extends AtaForm {

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

        // ٍEmail
        $email = new TextElement("email");
        $email->setLabel(_("Email"));
        $email->setAttribute("class", "form-control");
        $email->addValidator(new PresenceOf(array(
        )));
        $email->addValidator(new Email(array(
        )));
        $this->add($email);


        // Section
        $reason = new Select("section", array(
            'support' => _('Support'),
            'sale' => _('Sale'),
            'reseller' => _('Resseler')
        ));
        $reason->setLabel(_("Section"));
        $reason->setAttribute("class", "form-control");
        $this->add($reason);


        // Message
        $message = new TextAreaElement("message");
        $message->setAttribute("rows", 8);
        $message->setLabel(_("Message"));
        $message->setAttribute("class", "form-control");
        $message->addValidator(new PresenceOf(array(
        )));
        $message->addValidator(new StringLength(array(
            'min' => 10,
        )));
        $this->add($message);


        $settins = Settings::Get();

        // Map
        $map = new MapElement("map");
        $map->setLabel(_("Our Location"));
        $map->setLanguage("en");
        $map->setMarkTitle(_("Our Location"));
        $map->setMarkDescription(_("We are here"));
        $map->setLathitude($settins->latitude);
        $map->setLongtude($settins->longtude);
        $map->setZoom(12);
        $this->add($map);

        // Submit Button
        $submit = new Submit("submit");
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
