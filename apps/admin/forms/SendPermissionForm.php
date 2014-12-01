<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class SendPermissionForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('شناسه');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // User Post From
        $userpost1 = new SelectElement('userpost1', Post::find(), array(
            "using" => array(
                "id", "name"
            )
        ));
        $userpost1->setLabel('ارسال کننده');
        //$userpost1->setAttribute('placeholder', 'Enter your User Post From');
        $userpost1->setAttribute('class', 'form-control');
        $userpost1->addValidator(new PresenceOf(array(
        )));
        $this->add($userpost1);


        // User Post To
        $userpost2 = new SelectElement('userpost2', Post::find(), array(
            "using" => array(
                "id", "name"
            )
        ));
        $userpost2->setLabel('گیرنده');
        //$userpost2->setAttribute('placeholder', 'Enter your User Post To');
        $userpost2->setAttribute('class', 'form-control');
        $userpost2->addValidator(new PresenceOf(array(
        )));
        $this->add($userpost2);


        // Can Send
        $cansend = new EnableDisableElement('cansend');
        $cansend->setLabel('قابلیت ارسال');
        //$cansend->setAttribute('placeholder', 'Enter your Can Send');
        $cansend->setAttribute('class', 'form-control');
        $cansend->addValidator(new PresenceOf(array(
        )));
        $this->add($cansend);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $submit->setAttribute('value', 'ذخیره');
        $this->add($submit);
    }

}
