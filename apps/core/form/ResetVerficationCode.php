<?php

use Phalcon\Forms\Element\Submit;
use Simpledom\Core\AtaForm;

class ResetVerficationCode extends AtaForm {

    public function initialize() {


        // ٍEmail
        $email = new TextElement("email");
        $email->setLabel(_("Email"));
        $email->setAttribute("class", "form-control disabled");
        $this->add($email);


        // Submit Button
        $submit = new Submit("submit");
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
