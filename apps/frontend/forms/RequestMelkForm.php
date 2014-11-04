<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

/**
 * this will use melk search form items
 */
class RequestMelkForm extends MelkSearch {

    public function initialize() {

        parent::initialize();

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
        $email->setFooter("تماس های کاربران برای شما ارسال خواهد گردید");
        $email->setLabel(_("Email"));
        $email->setAttribute("class", "form-control");
        $email->addValidator(new Email(array(
        )));
        $this->add($email);


        // Password
        $password = new PasswordElement("password");
        $password->setLabel(_("Password"));
        $password->setInfo("بک رمز را به دلخواه انتخاب نمایید");
        $password->setFooter("رمز عبور برای ورود به سایت و تغییر اطلاعات ملک و تماس مورد استفاده قرار خواهد گرفت، پس در وارد نمودن آن ذقت نمایید");
        $password->setAttribute("class", "form-control");
        $this->add($password);



        // Home Size
        $home_size = new TextElement('home_size');
        $home_size->setLabel('زیربنا');
        //$home_size->setAttribute('placeholder', 'Enter your Home Size');
        $home_size->setAttribute('class', 'form-control');
        $home_size->setInfo('مقدار زیربنا را به متر مربع وارد نمایید');
        $this->add($home_size);


        // Lot Size
        $lot_size = new TextElement('lot_size');
        $lot_size->setLabel('متراژ زمین');
        $lot_size->setInfo('مقدار متراژ را به متر مربع وارد نمایید');
        //$lot_size->setAttribute('placeholder', 'Enter your Lot Size');
        $lot_size->setAttribute('class', 'form-control');
        $this->add($lot_size);


        // Address
        $address = new CityAreaSelector('address');
        $address->setLabel('مناطق درخواستی');
        $address->setCityID("$('#cityid').val()");
        $address->setInfo("نام مناطقی که به دنبال ملک می گردید را وارد نمایید");
        //$address->setAttribute('placeholder', 'Enter your Address');
        $address->setAttribute('class', 'form-control');
        $address->addValidator(new PresenceOf(array(
        )));
        $this->add($address);


        // Mobile
        $private_mobile = new TextElement('mobile');
        $private_mobile->setLabel('شماره موبایل');
        $private_mobile->setInfo("کد تایید ملک به شماره شما ارسال خواهد گردید، پس در وارد کردن آن دقت نمایید");
        //$private_mobile->setAttribute('placeholder', 'Enter your Private Mobile');
        $private_mobile->setAttribute('class', 'form-control');
        $private_mobile->addValidator(new PresenceOf(array(
        )));
        $this->add($private_mobile);


        // Submit Button
        $submit = new Submit('submit');
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute('class', 'btn btn-success btn-lg');
        $this->add($submit);
    }

}
