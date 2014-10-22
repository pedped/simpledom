<?php

namespace Simpledom\Core;

use EditorElement;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Simpledom\Core\AtaForm;

class EmailTemplateForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new Text('id');
        $id->setLabel(_('ID'));
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);

        // Name
        $name = new Text('name');
        $name->setLabel(_('Name'));
        //$name->setAttribute('placeholder', 'Enter your Name');
        $name->setAttribute('class', 'form-control');
        $name->addValidator(new PresenceOf(array(
        )));
        $name->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $this->add($name);

        // Template
        $template = new EditorElement('template');
        $template->setLabel('Template');
        //$template->setAttribute('placeholder', 'Enter your Template');
        $template->setAttribute('class', 'form-control');
        $template->addValidator(new PresenceOf(array(
        )));
        $template->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $this->add($template);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
