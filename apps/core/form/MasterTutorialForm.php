<?php

namespace Simpledom\Core;

use AreaChartElement;
use LineChartElement;
use PieChartElement;

class MasterTutorialForm extends AtaForm {

    public function initialize() {

        // Line Chart
        $linechart = new LineChartElement("linechart");
        $linechart->setLabel("Line Chart");
        $this->add($linechart);

        // Area Chart
        $areachart = new AreaChartElement("areachart");
        $areachart->setLabel("Area Chart");
        $this->add($areachart);

        // Pie Chart
        $piechart = new PieChartElement("piechart");
        $piechart->setLabel("Pie Chart");
        $this->add($piechart);
    }

}
