<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;

/**
 * this will use melk search form items
 */
class RequestMelkForm extends MelkSearch {

    public function initialize() {

        parent::initialize();

        // Mobile
        $private_mobile = new TextElement('mobile');
        $private_mobile->setLabel('شماره موبایل');
        $private_mobile->setInfo("کد تایید درخواست و مشخصات املاک به شماره شما ارسال خواهد گردید، پس در وارد کردن آن دقت نمایید");
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
