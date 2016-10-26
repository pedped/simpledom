<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class WorkerForm extends AtaForm {

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
//        $userid->addValidator(new PresenceOf(array(
//        )));
        $this->add($userid);


        // User ID
        $profileimage = new FileElement('profileimage');
        $profileimage->setLabel('تصویر کاربری');
        //$userid->setAttribute('placeholder', 'Enter your User ID');
//        $userid->addValidator(new PresenceOf(array(
//        )));
        $this->add($profileimage);


        $password = new TextElement('password');
        $password->setLabel('رمز عبور');
        //$firstname->setAttribute('placeholder', 'Enter your First Name');
        $password->setAttribute('class', 'form-control');
        $this->add($password);


        // First Name
        $gender = new EnableDisableElement('gender');
        $gender->setLabel('جنسیت');
        //$firstname->setAttribute('placeholder', 'Enter your First Name');
        $gender->setAttribute('class', 'form-control');
        $gender->addValidator(new PresenceOf(array(
        )));
        $this->add($gender);


        // First Name
        $firstname = new TextElement('firstname');
        $firstname->setLabel('نام');
        //$firstname->setAttribute('placeholder', 'Enter your First Name');
        $firstname->setAttribute('class', 'form-control');
        $firstname->addValidator(new PresenceOf(array(
        )));
        $this->add($firstname);


        // Last Name
        $lastname = new TextElement('lastname');
        $lastname->setLabel('نام خانوادگی');
        //$lastname->setAttribute('placeholder', 'Enter your Last Name');
        $lastname->setAttribute('class', 'form-control');
        $lastname->addValidator(new PresenceOf(array(
        )));
        $this->add($lastname);


        // Father Name
        $fathername = new TextElement('fathername');
        $fathername->setLabel('نام پدر');
        //$fathername->setAttribute('placeholder', 'Enter your Father Name');
        $fathername->setAttribute('class', 'form-control');
        $fathername->addValidator(new PresenceOf(array(
        )));
        $this->add($fathername);


        // Identity Number
        $identitynumber = new TextElement('identitynumber');
        $identitynumber->setLabel('شماره ملی');
        //$identitynumber->setAttribute('placeholder', 'Enter your Identity Number');
        $identitynumber->setAttribute('class', 'form-control');
        $identitynumber->addValidator(new PresenceOf(array(
        )));
        $this->add($identitynumber);


        // Birthday
        $birthday = new TextElement('birthday');
        $birthday->setLabel('تاریخ تولد');
        //$birthday->setAttribute('placeholder', 'Enter your Birthday');
        $birthday->setAttribute('class', 'form-control');
        $birthday->addValidator(new PresenceOf(array(
        )));
        $this->add($birthday);


        // Worker Section ID
        $workersectionid = new SelectElement('workersectionid', WorkerSection::find(), array(
            "using" => array(
                "id", "title"
            )
        ));
        $workersectionid->setLabel('سمت');
        //$workersectionid->setAttribute('placeholder', 'Enter your Worker Section ID');
        $workersectionid->setAttribute('class', 'form-control');
        $workersectionid->addValidator(new PresenceOf(array(
        )));
        $this->add($workersectionid);


        // Address
        $address = new TextAreaElement('address');
        $address->setLabel('آدرس محل سکونت');
        //$address->setAttribute('placeholder', 'Enter your Address');
        $address->setAttribute('class', 'form-control');
        $address->addValidator(new PresenceOf(array(
        )));
        $this->add($address);


        // Phone
        $phone = new TextElement('phone');
        $phone->setLabel('شماره تماس');
        //$phone->setAttribute('placeholder', 'Enter your Phone');
        $phone->setAttribute('class', 'form-control');
        $phone->addValidator(new PresenceOf(array(
        )));
        $this->add($phone);


        // Mobile
        $mobile = new TextElement('mobile');
        $mobile->setLabel('شماره موبایل');
        //$mobile->setAttribute('placeholder', 'Enter your Mobile');
        $mobile->setAttribute('class', 'form-control');
        $mobile->addValidator(new PresenceOf(array(
        )));
        $this->add($mobile);


        // Status
        $status = new EnableDisableElement('status');
        $status->setLabel('وضعیت');
        //$status->setAttribute('placeholder', 'Enter your Status');
        $status->setAttribute('class', 'form-control');
        $status->addValidator(new PresenceOf(array(
        )));
        $this->add($status);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
