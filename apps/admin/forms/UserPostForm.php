<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class UserPostForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // User ID
        $userid = new TextElement('userid');
        $userid->setLabel('کد کاربر');
        //$userid->setAttribute('placeholder', 'Enter your User ID');
        $userid->setAttribute('class', 'form-control');
        $this->add($userid);


        // Post ID
        $postid = new SelectElement('postid', Post::find(), array(
            "using" => array("id", "name")
        ));
        $postid->setLabel('سمت');
        //$postid->setAttribute('placeholder', 'Enter your Post ID');
        $postid->setAttribute('class', 'form-control');
        $postid->addValidator(new PresenceOf(array(
        )));
        $this->add($postid);


        // Code
        $code = new TextElement('code');
        $code->setLabel('کد اختصاصی');
        //$code->setAttribute('placeholder', 'Enter your Code');
        $code->setAttribute('class', 'form-control');
        $this->add($code);

        // Code
        $phonenumber = new TextElement('phonenumber');
        $phonenumber->setLabel('شماره تماس');
        $phonenumber->setAttribute('class', 'form-control');
        $phonenumber->addValidator(new PresenceOf(array(
        )));
        $this->add($phonenumber);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
