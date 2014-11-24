<?php

namespace Simpledom\Core;

use Opinion;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use SelectElement;
use TextAreaElement;
use TextElement;

class OpinionForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel(_('ID'));
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // User ID
        $userid = new TextElement('userid');
        $userid->setLabel(_('User ID'));
        //$userid->setAttribute('placeholder', 'Enter your User ID');
        $userid->setAttribute('class', 'form-control');
        $this->add($userid);


        // Name
        $name = new TextElement('name');
        $name->setLabel(_('Name'));
        //$name->setAttribute('placeholder', 'Enter your Name');
        $name->setAttribute('class', 'form-control');
        $name->addValidator(new PresenceOf(array(
        )));
        $name->addValidator(new StringLength(array(
            'min' => 4,
        )));
        $this->add($name);


        // Email
        $email = new TextElement('email');
        $email->setFooter("ایمیل شما در هیچ قسمت سایت نمایش داده نخواهد شد");
        $email->setLabel(_('Email'));
        //$email->setAttribute('placeholder', 'Enter your Email');
        $email->setAttribute('class', 'form-control');
        $email->addValidator(new PresenceOf(array(
        )));
        $email->addValidator(new StringLength(array(
            'min' => 6,
        )));
        $email->addValidator(new Email(array(
        )));
        $this->add($email);


        // Message
        $message = new TextAreaElement('message');
        $message->setLabel(_('Message'));
        $message->setAttribute('rows', '8');
        $message->setAttribute('class', 'form-control');
        $message->addValidator(new PresenceOf(array(
        )));
        $message->addValidator(new StringLength(array(
            'min' => 20,
        )));
        $this->add($message);


        // Date
        $date = new TextElement('date');
        $date->setLabel(_('Date'));
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);


        // Rating
        $rate = new SelectElement('rate');
        $rate->setLabel(_('Rating'));
        $rate->setOptions(Opinion::$DateValues);
        $rate->setAttribute('class', 'form-control');
        $rate->addValidator(new PresenceOf(array(
        )));
        $rate->addValidator(new InclusionIn(array(
            'domain' => array_keys(Opinion::$DateValues)
        )));
        $this->add($rate);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
