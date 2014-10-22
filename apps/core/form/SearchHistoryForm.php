<?php

namespace Simpledom\Core\SiteForms;

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Simpledom\Core\AtaForm;
use TextElement;

class SearchHistoryForm extends AtaForm {

    public function initialize() {

        // ID
        $id = new TextElement('id');
        $id->setLabel(_('ID'));
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // User ID
        $userid = new TextElement('userid');
        $userid->setLabel(_('User ID'));
        //$userid->setAttribute('placeholder', 'Enter your User ID');
        $userid->setAttribute('class', 'form-control');
        $this->add($userid);


        // Query
        $query = new TextElement('query');
        $query->setLabel(_('Query'));
        //$query->setAttribute('placeholder', 'Enter your Query');
        $query->setAttribute('class', 'form-control');
        $query->addValidator(new PresenceOf(array(
        )));
        $query->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $query->addValidator(new InclusionInValidator(array(
            'domain' => array_keys(SearchHistory::QueryValues),
            'max' => -1,
        )));
        $this->add($query);


        // Date
        $date = new TextElement('date');
        $date->setLabel(_('Date'));
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $date->addValidator(new PresenceOf(array(
        )));
        $date->addValidator(new StringLength(array(
            'min' => 11,
        )));
        $date->addValidator(new InclusionInValidator(array(
            'domain' => array_keys(SearchHistory::DateValues),
        )));
        $this->add($date);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
