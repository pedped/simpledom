<?php

namespace Simpledom\Core;

use EditorElement;
use EnableDisableElement;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Simpledom\Frontend\Controllers\ControllerBase;
use TextAreaElement;
use TextElement;

class SiteInfoForm extends AtaForm {

    public function initialize() {

        // Website name
        $websitename = new TextElement("websitename");
        $websitename->setLabel("Website Name");
        //$name->setAttribute("placeholder", "Enter your Full Name");
        $websitename->setAttribute("class", "form-control");
        $websitename->addValidator(new PresenceOf(array(
            'message' => 'The website name is required'
        )));
        $websitename->addValidator(new StringLength(array(
            'min' => 6,
            'messageMinimum' => 'The website is too short'
        )));
        $this->add($websitename);



        // Send Payment Receipt By Email
        $sendpaymentreceiptbyemail = new EnableDisableElement("sendpaymentreceiptbyemail");
        $sendpaymentreceiptbyemail->setLabel("Send Payment Receipt By Email");
        $sendpaymentreceiptbyemail->setAttribute("placeholder", "");
        $sendpaymentreceiptbyemail->setAttribute("class", "form-control");
        $this->add($sendpaymentreceiptbyemail);

        // Send Payment Receipt By Email
        $sendpaymentreceiptbysms = new EnableDisableElement("sendpaymentreceiptbysms");
        $sendpaymentreceiptbysms->setLabel("Send Payment Receipt By SMS");
        $sendpaymentreceiptbysms->setAttribute("placeholder", "");
        $sendpaymentreceiptbysms->setAttribute("class", "form-control");
        $this->add($sendpaymentreceiptbysms);


        // Request User Phone On Register
        $registerphoneonregister = new EnableDisableElement("requestuserphoneonregister");
        $registerphoneonregister->setLabel("Request User Phone On Register");
        $registerphoneonregister->setAttribute("placeholder", "");
        $registerphoneonregister->setAttribute("class", "form-control");
        $this->add($registerphoneonregister);

        // Request Verified Phone
        $requestverifiedphone = new EnableDisableElement("requestverifiedphone");
        $requestverifiedphone->setLabel("Request Verifed Phone");
        $requestverifiedphone->setAttribute("placeholder", "");
        $requestverifiedphone->setAttribute("class", "form-control");
        $this->add($requestverifiedphone);

        // Show News
        $shownews = new EnableDisableElement("shownews");
        $shownews->setLabel("Show News To Users");
        $shownews->setAttribute("placeholder", "");
        $shownews->setAttribute("class", "form-control");
        $this->add($shownews);
        
        // Search
        $search = new EnableDisableElement("enablesearch");
        $search->setLabel("Enable Search");
        $search->setAttribute("class", "form-control");
        $this->add($search);
        
        // Show News
        $rtl = new EnableDisableElement("rtl");
        $rtl->setLabel("RTL");
        $rtl->setAttribute("class", "form-control");
        $this->add($rtl);

        // Send News To Android\IPhone Users
        $sendnewstomobile = new EnableDisableElement("shownewsandroid");
        $sendnewstomobile->setLabel("Send News To Android\IPhone Users");
        $sendnewstomobile->setAttribute("placeholder", "");
        $sendnewstomobile->setAttribute("class", "form-control");
        $this->add($sendnewstomobile);

        // Global Message
        $globalmessage = new EditorElement("globalmessage");
        $globalmessage->setLabel("Global Message");
        $globalmessage->setAttribute("placeholder", "When you enter global message, everybody can see global message, make this form empty to disable global message showing");
        $globalmessage->setAttribute("class", "form-control");
        $this->add($globalmessage);


        // Enable Disable Signup
        $enabledisablesignup = new EnableDisableElement("enabledisablesignup");
        $enabledisablesignup->setLabel("Enable\Disable Signup");
        $enabledisablesignup->setAttribute("placeholder", "");
        $enabledisablesignup->setAttribute("class", "form-control");
        $this->add($enabledisablesignup);


        // Enable Disable Signin
        $enabledisablesiginin = new EnableDisableElement("enabledisablesignin");
        $enabledisablesiginin->setLabel("Enable\Disable Login");
        $enabledisablesiginin->setAttribute("placeholder", "");
        $enabledisablesiginin->setAttribute("class", "form-control");
        $this->add($enabledisablesiginin);


        // Website Logo
        // Metadata
        $metedata = new TextAreaElement("metadata");
        $metedata->setLabel("Metadata");
        $metedata->setAttribute("placeholder", "");
        $metedata->setAttribute("class", "form-control");
        $this->add($metedata);

        // Google Analytics
        $googleanalytics = new TextAreaElement("googlea");
        $googleanalytics->setLabel("Google Analytics Code");
        $googleanalytics->setAttribute("placeholder", "");
        $googleanalytics->setAttribute("class", "form-control");
        $this->add($googleanalytics);

        // Clicky Analytics
        $clicyanalytics = new TextAreaElement("clickya");
        $clicyanalytics->setLabel("Clicky Analytics Code");
        $clicyanalytics->setAttribute("placeholder", "");
        $clicyanalytics->setAttribute("class", "form-control");
        $this->add($clicyanalytics);


        // Keywords
        $keywords = new TextElement("keywords");
        $keywords->setLabel("Keywords");
        $keywords->setAttribute("placeholder", "seperate keywords by comma");
        $keywords->setAttribute("class", "form-control");
        $this->add($keywords);


        // Address
        $address = new TextArea("address");
        $address->setLabel("Address");
        $address->setAttribute("class", "form-control");
        $address->addValidator(new PresenceOf(array(
            'message' => 'The Address message is required'
        )));
        $address->addValidator(new StringLength(array(
            'min' => 20,
            'messageMinimum' => 'The Address message is too short'
        )));
        $this->add($address);


        $phone = new TextElement("phone");
        $phone->setLabel("Phone");
        $phone->setAttribute("class", "form-control");
        $phone->addValidator(new PresenceOf(array(
            'message' => 'The Phone is required'
        )));
        $phone->addValidator(new StringLength(array(
            'min' => 6,
            'messageMinimum' => 'The Phone is too short'
        )));
        $this->add($phone);


        $email = new TextElement("email");
        $email->setLabel("Support Email");
        $email->setAttribute("class", "form-control");
        $email->addValidator(new PresenceOf(array(
            'message' => 'The Support Email message is required'
        )));
        $email->addValidator(new StringLength(array(
            'min' => 8,
            'messageMinimum' => 'The Support Email message is too short'
        )));
        $this->add($email);


        // Latitude
        $latitude = new TextElement("latitude");
        $latitude->setLabel("Latitude");
        $latitude->setAttribute("placeholder", "");
        $latitude->setAttribute("class", "form-control");
        $this->add($latitude);


        // Longtude
        $longtude = new TextElement("longtude");
        $longtude->setLabel("Longtude");
        $longtude->setAttribute("placeholder", "");
        $longtude->setAttribute("class", "form-control");
        $this->add($longtude);


        // Google Crow Days
        // Submit Button
        $submit = new Submit("submit");
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

    /**
     * flash error message to controller
     * @param ControllerBase $controller
     * @param type $this
     */
    public function flashErrors(&$controller) {
        foreach ($this->getMessages() as $message) {
            $controller->flash->error($message);
        }
    }

}
