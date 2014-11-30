<?php

use Simpledom\Core\AtaForm;

class OrganDashboardForm extends AtaForm {

    public function initialize() {

        // Name
        $sentchart = new LineChartElement('sentchart');
        $sentchart->setTitle("پیامک های ارسالی");
        $sentchart->setSubtitle("نمودار پیامک های ارسای در 30 روز گذشته");
        $sentchart->setYAxis("تعداد");
        $sentchart->setXName("تاریخ");
        $sentchart->setAttribute('class', 'form-control');
        $this->add($sentchart);
    }

}
