<?php

namespace Simpledom\Core;

use EnableDisableElement;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use TextAreaElement;
use TextElement;

class FooterInfoForm extends AtaForm {

    public function initialize() {

        // Website name
        $footertitle = new TextElement("footertitle");
        $footertitle->setLabel(_("Footer Title"));
        //$name->setAttribute("placeholder", "Enter your Full Name");
        $footertitle->setAttribute("class", "form-control");
        $footertitle->addValidator(new PresenceOf(array(
        )));
        $footertitle->addValidator(new StringLength(array(
            'min' => 6,
        )));
        $this->add($footertitle);

        // Footer Text
        $footerText = new TextAreaElement("footertext");
        $footerText->setLabel(_("Footer Text"));
        $footerText->setAttribute("placeholder", _("Set your footer text here"));
        $footerText->setAttribute("class", "form-control");
        $this->add($footerText);


        // Address
        $footermenus = new TextAreaElement("footermenus");
        $footermenus->setLabel(_("Footer Menus"));
        $footermenus->setAttribute("class", "form-control");
        $footermenus->addValidator(new StringLength(array(
            'min' => 10,
        )));
        $this->add($footermenus);


        $footerenablecontact = new EnableDisableElement("footerenablecontact");
        $footerenablecontact->setLabel(_("Enable Footer Contact Form"));
        $footerenablecontact->setAttribute("class", "form-control");
        $this->add($footerenablecontact);


        // Submit Button
        $submit = new Submit("submit");
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
