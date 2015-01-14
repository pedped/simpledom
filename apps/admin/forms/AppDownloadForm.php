<?php

;

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;
use TextElement;

class AppDownloadForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // IP
        $ip = new TextElement('ip');
        $ip->setLabel('IP');
        //$ip->setAttribute('placeholder', 'Enter your IP');
        $ip->setAttribute('class', 'form-control');
        $ip->addValidator(new PresenceOf(array(
        )));
        $this->add($ip);


        // User ID
        $userid = new TextElement('userid');
        $userid->setLabel('User ID');
        //$userid->setAttribute('placeholder', 'Enter your User ID');
        $userid->setAttribute('class', 'form-control');
        $userid->addValidator(new PresenceOf(array(
        )));
        $this->add($userid);


        // Link
        $link = new TextElement('link');
        $link->setLabel('Link');
        //$link->setAttribute('placeholder', 'Enter your Link');
        $link->setAttribute('class', 'form-control');
        $link->addValidator(new PresenceOf(array(
        )));
        $this->add($link);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);


        // App Version
        $appversion = new TextElement('appversion');
        $appversion->setLabel('App Version');
        //$appversion->setAttribute('placeholder', 'Enter your App Version');
        $appversion->setAttribute('class', 'form-control');
        $appversion->addValidator(new PresenceOf(array(
        )));
        $this->add($appversion);


        // Agent
        $agent = new TextElement('agent');
        $agent->setLabel('Agent');
        //$agent->setAttribute('placeholder', 'Enter your Agent');
        $agent->setAttribute('class', 'form-control');
        $agent->addValidator(new PresenceOf(array(
        )));
        $this->add($agent);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
