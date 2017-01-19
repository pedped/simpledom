<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class UsercachchangeForm extends AtaForm {

    public function initialize() {


        // کد
        $id = new TextElement('id');
        $id->setLabel('کد');
        //$id->setAttribute('placeholder', 'Enter your کد');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // کاربر
        $userid = new TextElement('userid');
        $userid->setLabel('کاربر');
        //$userid->setAttribute('placeholder', 'Enter your کاربر');
        $userid->setAttribute('class', 'form-control');
        $userid->addValidator(new PresenceOf(array(
        )));
        $this->add($userid);


        // مقدار
        $amount = new TextElement('amount');
        $amount->setLabel('مقدار');
        //$amount->setAttribute('placeholder', 'Enter your مقدار');
        $amount->setAttribute('class', 'form-control');
        $amount->addValidator(new PresenceOf(array(
        )));
        $this->add($amount);


        // دلیل تغییر
        $reasonid = new SelectElement('reasonid', Cachchangereason::find(), array(
            "using" => array(
                "id", "name"
            )
        ));
        $reasonid->setLabel('دلیل تغییر');
        //$reasonid->setAttribute('placeholder', 'Enter your دلیل تغییر');
        $reasonid->setAttribute('class', 'form-control');
        $reasonid->addValidator(new PresenceOf(array(
        )));
        $this->add($reasonid);


        // اطلاعات بیشتر
        $more = new TextAreaElement('more');
        $more->setLabel('اطلاعات بیشتر');
        //$more->setAttribute('placeholder', 'Enter your اطلاعات بیشتر');
        $more->setAttribute('class', 'form-control');
        $this->add($more);



        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
