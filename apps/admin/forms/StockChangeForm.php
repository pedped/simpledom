<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class StockChangeForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Stock ID
        $stockid = new TextElement('stockid');
        $stockid->setLabel('کد ورودی کالا');
        //$stockid->setAttribute('placeholder', 'Enter your Stock ID');
        $stockid->setAttribute('class', 'form-control');
        $stockid->addValidator(new PresenceOf(array(
        )));
        $this->add($stockid);


        // User ID
        $userid = new TextElement('userid');
        $userid->setLabel('کاربر مربوطه');
        //$userid->setAttribute('placeholder', 'Enter your User ID');
        $userid->setAttribute('class', 'form-control');
        $userid->addValidator(new PresenceOf(array(
        )));
        $this->add($userid);


        // Worker ID
        $workerid = new TextElement('workerid');
        $workerid->setLabel('شماره کارگر');
        //$workerid->setAttribute('placeholder', 'Enter your Worker ID');
        $workerid->setAttribute('class', 'form-control');
        $workerid->addValidator(new PresenceOf(array(
        )));
        $this->add($workerid);


        // Count
        $count = new TextElement('count');
        $count->setLabel('تعداد');
        //$count->setAttribute('placeholder', 'Enter your Count');
        $count->setAttribute('class', 'form-control');
        $count->addValidator(new PresenceOf(array(
        )));
        $this->add($count);


        // Reason Code
        $reasoncode = new TextElement('reasoncode');
        $reasoncode->setLabel('دلیل');
        //$reasoncode->setAttribute('placeholder', 'Enter your Reason Code');
        $reasoncode->setAttribute('class', 'form-control');
        $reasoncode->addValidator(new PresenceOf(array(
        )));
        $this->add($reasoncode);


        // Reason
        $reason = new TextElement('reason');
        $reason->setLabel('توضیحات بیشتر');
        //$reason->setAttribute('placeholder', 'Enter your Reason');
        $reason->setAttribute('class', 'form-control');
        $reason->addValidator(new PresenceOf(array(
        )));
        $this->add($reason);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
