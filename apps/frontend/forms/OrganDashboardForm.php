<?php

use Simpledom\Core\AtaForm;

class OrganDashboardForm extends AtaForm {

    public function initialize() {

        // Name
        $sentchart = new LineChartElement('sentchart');
        $sentchart->setAttribute('class', 'form-control');
        $this->add($sentchart);
    }

}
