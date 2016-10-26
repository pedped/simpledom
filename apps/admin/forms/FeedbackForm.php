<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class FeedbackForm extends AtaForm {

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
        $this->add($userid);


        // Devcie Info
        $devcieinfo = new TextElement('devcieinfo');
        $devcieinfo->setLabel('Devcie Info');
        //$devcieinfo->setAttribute('placeholder', 'Enter your Devcie Info');
        $devcieinfo->setAttribute('class', 'form-control');
        $this->add($devcieinfo);


        // Result Type
        $result_type = new SelectElement('result_type', array(
            CONTACTSTATUS_WAITINGFORCALL => "منتظر تماس",
            CONTACTSTATUS_CALLED => "تماس گرفته شد",
            CONTACTSTATUS_NOTANSWERD => "عدم پاسخگویی کاربر",
        ));
        $result_type->setLabel('وضعیت تماس');
        //$result_type->setAttribute('placeholder', 'Enter your Result Type');
        $result_type->setAttribute('class', 'form-control');
        $result_type->addValidator(new PresenceOf(array()));
        $this->add($result_type);


        // Result Response
        $result_response = new TextAreaElement('result_response');
        $result_response->setLabel('درخواست مشتری');
        $result_response->setFooter("توضیح کوتاهی در ارتباط با درخواست مشتری یادداشت نماید");
        //$result_response->setAttribute('placeholder', 'Enter your Result Response');
        $result_response->setAttribute('class', 'form-control');
        $this->add($result_response);


        // Result Comment
        $result_comment = new TextAreaElement('result_comment');
        $result_comment->setLabel('نطرات اپراتور پیرامون گفتگو');
        //$result_comment->setAttribute('placeholder', 'Enter your Result Comment');
        $result_comment->setAttribute('class', 'form-control');
        $this->add($result_comment);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $submit->setAttribute('value', 'ارسال');
        $this->add($submit);
    }

}
