<?php

namespace Simpledom\Core;

use PaymentPayline;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\PresenceOf;
use SelectElement;
use Simpledom\Core\AtaForm;
use TextElement;

class PaymentPaylineForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // User ID
        $userid = new TextElement('userid');
        $userid->setLabel('User ID');
        //$userid->setAttribute('placeholder', 'Enter your User ID');
        $userid->setAttribute('class', 'form-control');
        $userid->addValidator(new PresenceOf(array(
        )));
        $this->add($userid);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $date->addValidator(new PresenceOf(array(
        )));
        $this->add($date);


        // Amount
        $amount = new TextElement('amount');
        $amount->setLabel('Amount');
        //$amount->setAttribute('placeholder', 'Enter your Amount');
        $amount->setAttribute('class', 'form-control');
        $amount->addValidator(new PresenceOf(array(
        )));
        $this->add($amount);


        // Currency
        $cur = new SelectElement('cur');
        $cur->setLabel('Currency');
        $cur->setOptions(PaymentPayline::$PaylineIDGetValues);
        //$cur->setAttribute('placeholder', 'Enter your Currency');
        $cur->setAttribute('class', 'form-control');
        $cur->addValidator(new PresenceOf(array(
        )));
        $cur->addValidator(new InclusionIn(array(
            'domain' => array_keys(PaymentPayline::$PaylineIDGetValues)
        )));
        $this->add($cur);


        // User Transaction ID
        $usertransactionid = new TextElement('usertransactionid');
        $usertransactionid->setLabel('User Transaction ID');
        //$usertransactionid->setAttribute('placeholder', 'Enter your User Transaction ID');
        $usertransactionid->setAttribute('class', 'form-control');
        $usertransactionid->addValidator(new PresenceOf(array(
        )));
        $this->add($usertransactionid);


        // Payline ID Get
        $paylineidget = new TextElement('paylineidget');
        $paylineidget->setLabel('Payline ID Get');
        //$paylineidget->setAttribute('placeholder', 'Enter your Payline ID Get');
        $paylineidget->setAttribute('class', 'form-control');
        $paylineidget->addValidator(new PresenceOf(array(
        )));
        $this->add($paylineidget);


        // Payline Transaction ID
        $paylinetransactionid = new TextElement('paylinetransactionid');
        $paylinetransactionid->setLabel('Payline Transaction ID');
        //$paylinetransactionid->setAttribute('placeholder', 'Enter your Payline Transaction ID');
        $paylinetransactionid->setAttribute('class', 'form-control');
        $paylinetransactionid->addValidator(new PresenceOf(array(
        )));
        $this->add($paylinetransactionid);


        // Done
        $done = new TextElement('done');
        $done->setLabel('Done');
        //$done->setAttribute('placeholder', 'Enter your Done');
        $done->setAttribute('class', 'form-control');
        $done->addValidator(new PresenceOf(array(
        )));
        $this->add($done);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
