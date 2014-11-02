<?php

namespace Simpledom\Frontend\Controllers;

use Simpledom\Core\AtaForm;
use Simpledom\Frontend\BaseControllers\IndexControllerBase;
use TagEditElement;

class IndexController extends IndexControllerBase {

    public function testAction() {
        $element = new TagEditElement("test");
        $element->setDefault(implode(",", array("سلام", "شیراز")));
//        $element->setAutocompleteSource("function(query ,response){"
//                . "console.log(query ,response);"
//                . "response(query.term + 'yes');"
//                . "}");

        $element->setAutocompleteSource("'http://melk.edspace.org/api/user/list'");

        $fr = new AtaForm();
        $fr->add($element);
        $this->view->form = $fr;
        $this->handleFormScripts($fr);
    }

}
