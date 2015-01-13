<?php

namespace Simpledom\Frontend\Controllers;

use Curl;
use Elka;
use PriceViewer;
use RangeSlider;
use Simpledom\Core\AtaForm;
use Simpledom\Frontend\BaseControllers\IndexControllerBase;
use SMSCreditCost;

class IndexController extends IndexControllerBase {

    public function indexAction() {
        parent::indexAction();
        $curl = new Curl();
        // var_dump($curl->post("http://84.241.39.143:8830/Mn.svc/TopUp/Status/5903/40963/", array()));
        //die();
        // try to connect to system
        $elka = new Elka($this->errors);
        die();
    }

    public function testAction() {


        var_dump($_SERVER);
        die();

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
