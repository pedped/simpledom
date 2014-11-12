<?php

namespace Simpledom\Frontend\Controllers;

use PriceViewer;
use Simpledom\Core\AtaForm;
use Simpledom\Frontend\BaseControllers\IndexControllerBase;
use SMSCreditCost;
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

    public function indexAction() {
        parent::indexAction();

        $viewr = new PriceViewer();
        $viewr->setPlans(SMSCreditCost::find());
        $viewr->setHeaderFieldName("title");
        $viewr->setSetPriceRowIndex(2);
        $viewr->setSetPurchaseFieldName("price");
        $viewr->setFields(array(
            "id",
            "title",
            "price",
            "description",
        ));
        $viewr->setInfos(array(
            "کد",
            "تیتر",
            "قیمت",
            "توضیحات",
        ));

        $kk = $viewr->Create();
        $this->view->plansss = $kk;
    }

}
