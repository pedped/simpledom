<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class QuestionForm extends AtaForm {

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


        // Moshaver ID
        $moshaverid = new TextElement('moshaverid');
        $moshaverid->setLabel('Moshaver ID');
        //$moshaverid->setAttribute('placeholder', 'Enter your Moshaver ID');
        $moshaverid->setAttribute('class', 'form-control');
        $moshaverid->addValidator(new PresenceOf(array(
        )));
        $this->add($moshaverid);


        // Question
        $question = new TextElement('question');
        $question->setLabel('Question');
        //$question->setAttribute('placeholder', 'Enter your Question');
        $question->setAttribute('class', 'form-control');
        $question->addValidator(new PresenceOf(array(
        )));
        $this->add($question);


        // About Yourself
        $aboutyourself = new TextAreaElement('aboutyourself');
        $aboutyourself->setLabel('About Yourself');
        //$aboutyourself->setAttribute('placeholder', 'Enter your About Yourself');
        $aboutyourself->setAttribute('class', 'form-control');
        $this->add($aboutyourself);


        // Disorder History
        $disorderhistory = new TextElement('disorderhistory');
        $disorderhistory->setLabel('Disorder History');
        //$disorderhistory->setAttribute('placeholder', 'Enter your Disorder History');
        $disorderhistory->setAttribute('class', 'form-control');
        $this->add($disorderhistory);


        // Using Tablet
        $usingtablet = new SelectElement('usingtablet');
        $usingtablet->setLabel('Using Tablet');
        //$usingtablet->setAttribute('placeholder', 'Enter your Using Tablet');
        $usingtablet->setAttribute('class', 'form-control');
        $this->add($usingtablet);


        // City ID
        $cityid = new SelectElement('cityid');
        $cityid->setLabel('City ID');
        //$cityid->setAttribute('placeholder', 'Enter your City ID');
        $cityid->setAttribute('class', 'form-control');
        $cityid->addValidator(new PresenceOf(array(
        )));
        $this->add($cityid);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
