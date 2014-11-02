<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class ValidProviderIPForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Provider
        $providerid = new SelectElement('providerid', SMSProvider::find(), array(
            "using" => array(
                "id", "name"
            )
        ));
        
        
        $providerid->setLabel('Provider');
        //$providerid->setAttribute('placeholder', 'Enter your Provider');
        $providerid->setAttribute('class', 'form-control');
        $providerid->addValidator(new PresenceOf(array(
        )));
        $this->add($providerid);


        // IP
        $ip = new TextElement('ip');
        $ip->setLabel('IP');
        //$ip->setAttribute('placeholder', 'Enter your IP');
        $ip->setAttribute('class', 'form-control');
        $ip->addValidator(new PresenceOf(array(
        )));
        $this->add($ip);


        // Enable
        $enable = new EnableDisableElement('enable');
        $enable->setLabel('Enable');
        //$enable->setAttribute('placeholder', 'Enter your Enable');
        $enable->setAttribute('class', 'form-control');
        $enable->addValidator(new PresenceOf(array(
        )));
        $this->add($enable);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
