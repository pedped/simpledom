<?php

namespace Simpledom\Core;

use EnableDisableElement;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use TextAreaElement;
use TextElement;

class WebsiteOfflineForm extends AtaForm {

    public function initialize() {

        // Offline Mode
        $footerenablecontact = new EnableDisableElement("offline");
        $footerenablecontact->setLabel("Offline Website ?");
        $footerenablecontact->setAttribute("class", "form-control");
        $this->add($footerenablecontact);



        // Footer Text
        $footerText = new TextAreaElement("offlinemessage");
        $footerText->setLabel("Footer Text");
        $footerText->setAttribute("placeholder", "set your footer text here");
        $footerText->setAttribute("class", "form-control");
        $this->add($footerText);



        // Submit Button
        $submit = new Submit("submit");
        $submit->setName("submit");
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
