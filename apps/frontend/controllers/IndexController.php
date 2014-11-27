<?php

namespace Simpledom\Frontend\Controllers;

use PriceViewer;
use RangeSlider;
use Simpledom\Core\AtaForm;
use Simpledom\Frontend\BaseControllers\IndexControllerBase;
use SMSCreditCost;

class IndexController extends IndexControllerBase {

    public function testAction() {

        $element = new RangeSlider("slider");
        $element->min = 50;
        $element->max = 500;
        $element->currentMinValue = 65;
        $element->currentMaxValue = 256;
        $element->betweenRangeTitle = "تا";


        $fr = new AtaForm();
        $fr->add($element);
        $this->view->form = $fr;
        $this->handleFormScripts($fr);


        $viewr = new PriceViewer();
        $viewr->setPlans(SMSCreditCost::find());
        $viewr->setHeaderFieldName("title");
        $viewr->setFields(array(
            "id",
            "title",
        ));
        $viewr->setInfos(array(
            "کد",
            "تیتر",
        ));


        $this->view->plansss = $viewr->Create();
    }

}
