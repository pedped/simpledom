<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Simpledom\Core\AtaForm;

class SystemLogForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new Text('id');
        $id->setLabel(_('ID'));
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);

        // Title
        $title = new Text('title');
        $title->setLabel(_('Title'));
        //$title->setAttribute('placeholder', 'Enter your Title');
        $title->setAttribute('class', 'form-control');
        $title->addValidator(new PresenceOf(array(
        )));
        $title->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $this->add($title);

        // IP
        $ip = new Text('ip');
        $ip->setLabel(_('IP'));
        //$ip->setAttribute('placeholder', 'Enter your IP');
        $ip->setAttribute('class', 'form-control');
        $ip->addValidator(new PresenceOf(array(
        )));
        $ip->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $this->add($ip);

        // Message
        $message = new Text('message');
        $message->setLabel(_('Message'));
        //$message->setAttribute('placeholder', 'Enter your Message');
        $message->setAttribute('class', 'form-control');
        $message->addValidator(new PresenceOf(array(
        )));
        $message->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $this->add($message);

        // Date
        $date = new Text('date');
        $date->setLabel(_('Date'));
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $date->addValidator(new PresenceOf(array(
        )));
        $date->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $this->add($date);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
