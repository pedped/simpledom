<?php

namespace Simpledom\Core;

use EnableDisableElement;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use TextAreaElement;

class ViewUserForm extends AtaForm {

    public function initialize() {



        // First Name
        $firstname = new Text("firstname");
        $firstname->setLabel(_("First Name"));
        $firstname->setAttribute("placeholder", _("Enter your First Name"));
        $firstname->setAttribute("class", "form-control");
        $firstname->addValidator(new PresenceOf(array(
        )));
        $firstname->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $this->add($firstname);



        // Last Name
        $lastname = new Text("lastname");
        $lastname->setLabel(_("Last Name"));
        $lastname->setAttribute("placeholder", _("Enter your Last Name"));
        $lastname->setAttribute("class", "form-control");
        $lastname->addValidator(new PresenceOf(array(
        )));
        $lastname->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $this->add($lastname);


        // Gender
        $gender = new Select("gender", array(
            '1' => _('Male'),
            '0' => _('Female')
        ));
        $gender->setLabel(_("Gender"));
        $gender->setAttribute("class", "form-control");
        $this->add($gender);


        // Active
        $active = new EnableDisableElement("active");
        $active->setLabel(_("Active"));
        $active->setAttribute("class", "form-control");
        $this->add($active);

        // Verify
        $verify = new EnableDisableElement("verify");
        $verify->setLabel(_("Verified"));
        $verify->setAttribute("class", "form-control");
        $this->add($verify);


        // Disable Message
        $disablemessage = new TextAreaElement("disablemessage");
        $disablemessage->setLabel(_("Disabled Account Message"));
        $disablemessage->setAttribute("placeholder", _("When you make user offline, you may use offline message for the user"));
        $disablemessage->setAttribute("class", "form-control");
        $this->add($disablemessage);


        // Submit Button
        $submit = new Submit("submit");
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
