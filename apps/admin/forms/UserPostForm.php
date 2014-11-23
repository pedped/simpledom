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
        $userid->setLabel('User ID');
        //$userid->setAttribute('placeholder', 'Enter your User ID');
        $userid->setAttribute('class', 'form-control');
        $userid->addValidator(new PresenceOf(array(
        )));
        $this->add($userid);


        // Post ID
        $postid = new TextElement('postid');
        $postid->setLabel('Post ID');
        //$postid->setAttribute('placeholder', 'Enter your Post ID');
        $postid->setAttribute('class', 'form-control');
        $postid->addValidator(new PresenceOf(array(
        )));
        $this->add($postid);


        // Code
        $code = new TextElement('code');
        $code->setLabel('Code');
        //$code->setAttribute('placeholder', 'Enter your Code');
        $code->setAttribute('class', 'form-control');
        $this->add($code);
        
        // Code
        $phonenumber = new TextElement('phonenumber');
        $phonenumber->setLabel('Phone Number');
        $phonenumber->setAttribute('class', 'form-control');
        $this->add($phonenumber);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
