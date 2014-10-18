<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Logger\Adapter\File;
use Simpledom\Core\AtaForm;

namespace Simpledom\Core;

class UploadImageForm extends AtaForm {

    public function initialize() {


        // Path
        $file = new File('file');
        $file->setLabel('File');
        $this->add($file);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
