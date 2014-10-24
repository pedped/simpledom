<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;
use TextElement;

class UserTransactionForm extends AtaForm {

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
        $userid->addValidator(new PresenceOf(array(
        )));
        $this->add($userid);


        // Amount
        $amount = new TextElement('amount');
        $amount->setLabel(_('Amount'));
        //$amount->setAttribute('placeholder', 'Enter your Amount');
        $amount->setAttribute('class', 'form-control');
        $amount->addValidator(new PresenceOf(array(
        )));
        $this->add($amount);


        // Currency
        $cur = new TextElement('cur');
        $cur->setLabel(_('Currency'));
        //$cur->setAttribute('placeholder', 'Enter your Currency');
        $cur->setAttribute('class', 'form-control');
        $cur->addValidator(new PresenceOf(array(
        )));
        $this->add($cur);


        // Type
        $type = new TextElement('type');
        $type->setLabel(_('Type'));
        //$type->setAttribute('placeholder', 'Enter your Type');
        $type->setAttribute('class', 'form-control');
        $type->addValidator(new PresenceOf(array(
        )));
        $this->add($type);


        // Type Name
        $typename = new TextElement('typename');
        $typename->setLabel(_('Type Name'));
        //$typename->setAttribute('placeholder', 'Enter your Type Name');
        $typename->setAttribute('class', 'form-control');
        $typename->addValidator(new PresenceOf(array(
        )));
        $this->add($typename);


        // Item ID
        $itemid = new TextElement('itemid');
        $itemid->setLabel(_('Item ID'));
        //$itemid->setAttribute('placeholder', 'Enter your Item ID');
        $itemid->setAttribute('class', 'form-control');
        $itemid->addValidator(new PresenceOf(array(
        )));
        $this->add($itemid);


        // Date
        $date = new TextElement('date');
        $date->setLabel(_('Date'));
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $date->addValidator(new PresenceOf(array(
        )));
        $this->add($date);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
