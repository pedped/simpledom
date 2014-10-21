<?php

use Phalcon\Forms\Element\File;
use Phalcon\Forms\Element\Submit;
use Simpledom\Core\AtaForm;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfileImageForm
 *
 * @author pedram
 */
class ProfileImageForm extends AtaForm {

    public function initialize() {

        // File
        $file = new File("file");
        $file->setLabel(_("Choose Your File"));
        $this->add($file);


        // Image
        $image = new ImageElement("image");
        $image->setLabel(_("Image"));
        $image->setAttribute("class", "img img-responsive");
        $this->add($image);


        // Submit Button
        $submit = new Submit("submit");
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
