<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class SendBongahSmsForm extends AtaForm {

    public function initialize() {

        // Title
        $area = new TagEditElement('area');
        $area->setLabel('مناطق ارسالی');
        $area->setAttribute('class', 'form-control');
        $area->addValidator(new PresenceOf(array(
        )));
        $this->add($area);

        // Title
        $message = new TextAreaElement('message');
        $message->setLabel('متن پیامک');
        //$title->setAttribute('placeholder', 'Enter your Title');
        $message->setAttribute('class', 'form-control');
        $message->addValidator(new PresenceOf(array(
        )));
        $this->add($message);


        // Shomare Peygiri
        $sendtolistners = new CheckElement('sendtolistners');
        $sendtolistners->setCheckboxText('ارسال پیامک به مشتریان تحت پوشش');
        $this->add($sendtolistners);


        // First Name
        $sendtomelkusers = new CheckElement('sendtomelkusers');
        $sendtomelkusers->setCheckboxText('ارسال پیامک به صاحبان املاک');
        $this->add($sendtomelkusers);


        // Submit Button
        $submit = new Submit('submit');
        $submit->setAttribute('value', 'ارسال');
        $submit->setAttribute('class', 'btn btn-success btn-lg');
        $this->add($submit);
    }

}
