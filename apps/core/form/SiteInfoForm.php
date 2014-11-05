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
        $websitename->setLabel(_("Website Name"));
        //$name->setAttribute("placeholder", "Enter your Full Name");
        $websitename->setAttribute("class", "form-control");
        $websitename->addValidator(new PresenceOf(array(
        )));
        $websitename->addValidator(new StringLength(array(
            'min' => 6,
        )));
        $this->add($websitename);


        // Recapctha
        $recaptchapublic = new TextElement("recaptchapublic");
        $recaptchapublic->setLabel(_("Public Recaptcha Key"));
        //$name->setAttribute("placeholder", "Enter your Full Name");
        $recaptchapublic->setAttribute("class", "form-control");
        $recaptchapublic->addValidator(new StringLength(array(
            'min' => 6,
        )));
        $this->add($recaptchapublic);


        $recaptchaprivate = new TextElement("recaptchaprivate");
        $recaptchaprivate->setLabel(_("Private Recaptcha Key"));
        //$name->setAttribute("placeholder", "Enter your Full Name");
        $recaptchaprivate->setAttribute("class", "form-control");
        $recaptchaprivate->addValidator(new StringLength(array(
            'min' => 6,
        )));
        $this->add($recaptchaprivate);



        // Send Payment Receipt By Email
        $sendpaymentreceiptbyemail = new EnableDisableElement("sendpaymentreceiptbyemail");
        $sendpaymentreceiptbyemail->setLabel(_("Send Payment Receipt By Email"));
        $sendpaymentreceiptbyemail->setAttribute("placeholder", "");
        $sendpaymentreceiptbyemail->setAttribute("class", "form-control");
        $this->add($sendpaymentreceiptbyemail);

        // Send Payment Receipt By Email
        $sendpaymentreceiptbysms = new EnableDisableElement("sendpaymentreceiptbysms");
        $sendpaymentreceiptbysms->setLabel(_("Send Payment Receipt By SMS"));
        $sendpaymentreceiptbysms->setAttribute("placeholder", "");
        $sendpaymentreceiptbysms->setAttribute("class", "form-control");
        $this->add($sendpaymentreceiptbysms);


        // Request User Phone On Register
        $registerphoneonregister = new EnableDisableElement("requestuserphoneonregister");
        $registerphoneonregister->setLabel(_("Request User Phone On Register"));
        $registerphoneonregister->setAttribute("placeholder", "");
        $registerphoneonregister->setAttribute("class", "form-control");
        $this->add($registerphoneonregister);

        // Request Verified Phone
        $requestverifiedphone = new EnableDisableElement("requestverifiedphone");
        $requestverifiedphone->setLabel(_("Request Verifed Phone"));
        $requestverifiedphone->setAttribute("placeholder", "");
        $requestverifiedphone->setAttribute("class", "form-control");
        $this->add($requestverifiedphone);

        // Show News
        $shownews = new EnableDisableElement("shownews");
        $shownews->setLabel(_("Show News To Users"));
        $shownews->setAttribute("placeholder", "");
        $shownews->setAttribute("class", "form-control");
        $this->add($shownews);

        // Search
        $search = new EnableDisableElement("enablesearch");
        $search->setLabel(_("Enable Search"));
        $search->setAttribute("class", "form-control");
        $this->add($search);

        // Show News
        $rtl = new EnableDisableElement("rtl");
        $rtl->setLabel(_("RTL"));
        $rtl->setAttribute("class", "form-control");
        $this->add($rtl);

        // Send News To Android\IPhone Users
        $sendnewstomobile = new EnableDisableElement("shownewsandroid");
        $sendnewstomobile->setLabel(_("Send News To Android\IPhone Users"));
        $sendnewstomobile->setAttribute("placeholder", "");
        $sendnewstomobile->setAttribute("class", "form-control");
        $this->add($sendnewstomobile);

        // Global Message
        $globalmessage = new EditorElement("globalmessage");
        $globalmessage->setLabel(_("Global Message"));
        $globalmessage->setAttribute("placeholder", _("When you enter global message, everybody can see global message, make this form empty to disable global message showing"));
        $globalmessage->setAttribute("class", "form-control");
        $this->add($globalmessage);


        // Enable Disable Signup
        $enabledisablesignup = new EnableDisableElement("enabledisablesignup");
        $enabledisablesignup->setLabel(_("Enable\Disable Signup"));
        $enabledisablesignup->setAttribute("placeholder", "");
        $enabledisablesignup->setAttribute("class", "form-control");
        $this->add($enabledisablesignup);


        // Enable Disable Signin
        $enabledisablesiginin = new EnableDisableElement("enabledisablesignin");
        $enabledisablesiginin->setLabel(_("Enable\Disable Login"));
        $enabledisablesiginin->setAttribute("placeholder", "");
        $enabledisablesiginin->setAttribute("class", "form-control");
        $this->add($enabledisablesiginin);


        // Website Logo
        // Metadata
        $metedata = new TextAreaElement("metadata");
        $metedata->setLabel(_("Metadata"));
        $metedata->setAttribute("placeholder", "");
        $metedata->setAttribute("class", "form-control");
        $this->add($metedata);

        // Google Analytics
        $googleanalytics = new TextAreaElement("googlea");
        $googleanalytics->setLabel(_("Google Analytics Code"));
        $googleanalytics->setAttribute("placeholder", "");
        $googleanalytics->setAttribute("class", "form-control");
        $this->add($googleanalytics);

        // Clicky Analytics
        $clicyanalytics = new TextAreaElement("clickya");
        $clicyanalytics->setLabel(_("Clicky Analytics Code"));
        $clicyanalytics->setAttribute("placeholder", "");
        $clicyanalytics->setAttribute("class", "form-control");
        $this->add($clicyanalytics);


        // Keywords
        $keywords = new TextElement("keywords");
        $keywords->setLabel(_("Keywords"));
        $keywords->setAttribute("placeholder", _("seperate keywords by comma"));
        $keywords->setAttribute("class", "form-control");
        $this->add($keywords);


        // Address
        $address = new TextArea("address");
        $address->setLabel(_("Address"));
        $address->setAttribute("class", "form-control");
        $address->addValidator(new PresenceOf(array(
        )));
        $address->addValidator(new StringLength(array(
            'min' => 20,
        )));
        $this->add($address);


        $phone = new TextElement("phone");
        $phone->setLabel(_("Phone"));
        $phone->setAttribute("class", "form-control");
        $phone->addValidator(new PresenceOf(array(
        )));
        $phone->addValidator(new StringLength(array(
            'min' => 6,
        )));
        $this->add($phone);


        $email = new TextElement("email");
        $email->setLabel(_("Support Email"));
        $email->setAttribute("class", "form-control");
        $email->addValidator(new PresenceOf(array(
        )));
        $email->addValidator(new StringLength(array(
            'min' => 8,
        )));
        $this->add($email);


        // Latitude
        $latitude = new TextElement("latitude");
        $latitude->setLabel(_("Latitude"));
        $latitude->setAttribute("placeholder", "");
        $latitude->setAttribute("class", "form-control");
        $this->add($latitude);


        // Longtude
        $longtude = new TextElement("longtude");
        $longtude->setLabel(_("Longtude"));
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
