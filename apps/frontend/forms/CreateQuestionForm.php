<?php

use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Simpledom\Core\AtaForm;

class CreateQuestionForm extends AtaForm {

    public function initialize() {


        // Moshaver ID
        $moshaverid = new Hidden('moshaverid');
        $moshaverid->addValidator(new PresenceOf(array(
        )));
        $this->add($moshaverid);




        // First Name
        $firstname = new TextElement("fname");
        $firstname->setLabel(_("First Name"));
        $firstname->setAttribute("class", "form-control");
        $firstname->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $this->add($firstname);


        // Last Name
        $lastname = new TextElement("lname");
        $lastname->setLabel(_("Last Name"));
        $lastname->setAttribute("class", "form-control");
        $lastname->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $this->add($lastname);

        // ٍEmail
        $email = new TextElement("email");
        $email->setLabel(_("Email"));
        $email->setAttribute("class", "form-control");
        $email->addValidator(new Email(array(
        )));
        $this->add($email);

        // Question
        $question = new TextAreaElement('question');
        $question->setAttribute('rows', 5);
        $question->setLabel('سوال');
        //$question->setAttribute('placeholder', 'Enter your Question');
        $question->setAttribute('class', 'form-control');
        $question->addValidator(new PresenceOf(array(
        )));
        $this->add($question);


        // About Yourself
        $aboutyourself = new TextAreaElement('aboutyourself');
        $aboutyourself->setLabel('در مورد شما');
        $aboutyourself->setAttribute('rows', 5);
        //$aboutyourself->setAttribute('placeholder', 'Enter your About Yourself');
        $aboutyourself->setAttribute('class', 'form-control');
        $this->add($aboutyourself);


        // Disorder History
        $disorderhistory = new TextAreaElement('disorderhistory');
        $disorderhistory->setLabel('سابقه بیماری');
        $disorderhistory->setAttribute('rows', 5);
        //$disorderhistory->setAttribute('placeholder', 'Enter your Disorder History');
        $disorderhistory->setAttribute('class', 'form-control');
        $this->add($disorderhistory);


        // Using Tablet
        $usingtablet = new TextElement('usingtablet');
        $usingtablet->setLabel('سابقه مصرف دارو');
        //$usingtablet->setAttribute('placeholder', 'Enter your Using Tablet');
        $usingtablet->setAttribute('class', 'form-control');
        $this->add($usingtablet);


        // Mobile
        $phone = new TextElement('phone');
        $phone->setLabel('شماره موبایل');
        //$usingtablet->setAttribute('placeholder', 'Enter your Using Tablet');
        $phone->setAttribute('class', 'form-control');
        $phone->addValidator(new PresenceOf(array(
        )));
        $this->add($phone);

        // City ID
        $cityid = new SelectElement('cityid', City::find(), array(
            "using" => array("id", "name")
        ));
        $cityid->setLabel('شهر');
        //$cityid->setAttribute('placeholder', 'Enter your City ID');
        $cityid->setAttribute('class', 'form-control');
        $cityid->addValidator(new PresenceOf(array(
        )));
        $this->add($cityid);


        // State ID
        $stateid = new SelectElement('stateid', State::find(), array(
            "using" => array("id", "name")
        ));
        $stateid->setLabel('استان');
        //$stateid->setAttribute('placeholder', 'Enter your City ID');
        $stateid->setAttribute('class', 'form-control');
        $stateid->addValidator(new PresenceOf(array(
        )));
        $this->add($stateid);


        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute("value", "ارسال");
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
