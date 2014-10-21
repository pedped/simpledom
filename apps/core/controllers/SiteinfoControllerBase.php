<?php

namespace Simpledom\Admin\BaseControllers;

use Settings;
use Simpledom\Core\FooterInfoForm;
use Simpledom\Core\SiteInfoForm;
use Simpledom\Core\WebsiteOfflineForm;

class SiteinfoControllerBase extends ControllerBase {

    public function infoAction() {

        // set page title
        $this->setTitle("Site Info");

        // load settings
        $settings = Settings::Get();
        $fr = new SiteInfoForm();
        if ($this->request->isPost()) {
            if (!$fr->isValid($_POST)) {
                // invalid request
                $fr->flashErrors($this);
            } else {
                // valid request
                $settings->websitename = $this->request->getPost("websitename");
                $settings->contactemail = $this->request->getPost("email");
                $settings->contactphone = $this->request->getPost("phone");
                $settings->address = $this->request->getPost("address");
                $settings->keywords = $this->request->getPost("keywords");
                $settings->metadata = $this->request->getPost("metadata");
                $settings->latitude = $this->request->getPost("latitude");
                $settings->longtude = $this->request->getPost("longtude");
                $settings->enabledisablesignup = $this->request->getPost("enabledisablesignup");
                $settings->enabledisablesignin = $this->request->getPost("enabledisablesignin");

                // analytics
                $settings->googleanalytics = $this->request->getPost("googlea");
                $settings->clickyanalitics = $this->request->getPost("clickya");

                // payment receipt
                $settings->sendpaymentreceiptbyemail = $this->request->getPost("sendpaymentreceiptbyemail");
                $settings->sendpaymentreceiptbysms = $this->request->getPost("sendpaymentreceiptbysms");


                $settings->requestuserphoneonregister = $this->request->getPost("requestuserphoneonregister");
                $settings->requestverifiedphone = $this->request->getPost("requestverifiedphone");
                $settings->shownewsandroid = $this->request->getPost("shownews");
                $settings->shownewsandroid = $this->request->getPost("shownewsandroid");
                $settings->globalmessage = $this->request->getPost("globalmessage");

                if (!$settings->save()) {
                    $settings->showErrorMessages($this);
                } else {
                    $settings->showSuccessMessages($this, "Website Settings Saved Successfully");
                }
            }
        }


        // Set Default Items
        $fr->get("websitename")->setDefault($settings->websitename);
        $fr->get("email")->setDefault($settings->contactemail);
        $fr->get("phone")->setDefault($settings->contactphone);
        $fr->get("address")->setDefault($settings->address);
        $fr->get("keywords")->setDefault($settings->keywords);
        $fr->get("metadata")->setDefault($settings->metadata);
        $fr->get("latitude")->setDefault($settings->latitude);
        $fr->get("longtude")->setDefault($settings->longtude);
        $fr->get("enabledisablesignin")->setDefault($settings->enabledisablesignin);
        $fr->get("enabledisablesignup")->setDefault($settings->enabledisablesignup);
        $fr->get("googlea")->setDefault($settings->googleanalytics);
        $fr->get("clickya")->setDefault($settings->clickyanalitics);

        $fr->get("sendpaymentreceiptbyemail")->setDefault($settings->sendpaymentreceiptbyemail);
        $fr->get("sendpaymentreceiptbysms")->setDefault($settings->sendpaymentreceiptbysms);

        // Phone settings
        $fr->get("requestuserphoneonregister")->setDefault($settings->requestuserphoneonregister);
        $fr->get("requestverifiedphone")->setDefault($settings->requestverifiedphone);
        $fr->get("shownews")->setDefault($settings->shownews);
        $fr->get("shownewsandroid")->setDefault($settings->shownewsandroid);
        $fr->get("globalmessage")->setDefault($settings->globalmessage);

        $this->handleFormScripts($fr);
        $this->view->siteInfoForm = $fr;
    }

    public function footerAction() {

        // set page title
        $this->setTitle("Website Footer Text");

        // load settings
        $settings = Settings::Get();
        $fr = new FooterInfoForm();
        if ($this->request->isPost()) {
            if (!$fr->isValid($_POST)) {
                // invalid request
                $fr->flashErrors($this);
            } else {
                // valid request
                $settings->footertitle = $this->request->getPost("footertitle");
                $settings->footertext = $this->request->getPost("footertext");
                $settings->footermenus = $this->request->getPost("footermenus");
                $settings->footerenablecontact = $this->request->getPost("footerenablecontact");
                if (!$settings->save()) {
                    $settings->showErrorMessages($this);
                } else {
                    $settings->showSuccessMessages($this, "Website Footer Saved Successfully");
                }
            }
        }


        // Set Default Items
        $fr->get("footertitle")->setDefault($settings->footertitle);
        $fr->get("footertext")->setDefault($settings->footertext);
        $fr->get("footermenus")->setDefault($settings->footermenus);
        $fr->get("footerenablecontact")->setDefault($settings->footerenablecontact);
        $this->view->siteInfoForm = $fr;
    }

    public function changestateAction() {

        // set page title
        $this->setTitle("Website Offline Settings");

        // load settings
        $settings = Settings::Get();
        $fr = new WebsiteOfflineForm();
        if ($this->request->isPost()) {
            if (!$fr->isValid($_POST)) {
                // invalid request
                $fr->flashErrors($this);
            } else {
                // valid request
                $settings->offline = $this->request->getPost("offline");
                $settings->offlinemessage = $this->request->getPost("offlinemessage");
                if (!$settings->save()) {
                    $settings->showErrorMessages($this);
                } else {
                    $settings->showSuccessMessages($this, "Website Offline Settings Changed Successfully");
                }
            }
        }


        // Set Default Items
        $fr->get("offline")->setDefault($settings->offline);
        $fr->get("offlinemessage")->setDefault($settings->offlinemessage);
        $this->view->siteInfoForm = $fr;
    }

    protected function ValidateAccess($id) {
        
    }

}
