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


        // Query
        $query = new TextElement('query');
        $query->setLabel('Query');
        //$query->setAttribute('placeholder', 'Enter your Query');
        $query->setAttribute('class', 'form-control');
        $query->addValidator(new PresenceOf(array(
            'message' => 'The Query is required'
        )));
        $query->addValidator(new StringLength(array(
            'min' => 2,
            'messageMinimum' => 'The Query is too short'
        )));
        $query->addValidator(new InclusionInValidator(array(
            'domain' => array_keys(SearchHistory::QueryValues),
            'max' => -1,
            'domain' => 'invalid item for Query'
        )));
        $this->add($query);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $date->addValidator(new PresenceOf(array(
            'message' => 'The Date is required'
        )));
        $date->addValidator(new StringLength(array(
            'min' => 11,
            'messageMinimum' => 'The Date is too short'
        )));
        $date->addValidator(new InclusionInValidator(array(
            'domain' => array_keys(SearchHistory::DateValues),
            'max' => -1,
            'domain' => 'invalid item for Date'
        )));
        $this->add($date);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
