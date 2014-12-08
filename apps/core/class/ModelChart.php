<?php

use Simpledom\Core\AtaModel;

/**
 * this model will create a chart element for the model based on date field ( unix field )
 *
 * @author ataalla
 */
class ModelChart {

    /**
     * Model that we have to get filed
     * @var AtaModel 
     */
    private $model;

    /**
     * Chart ELement
     * @var LineChartElement
     */
    private $chart;

    /**
     *
     * @var Array 
     */
    private $dateRange;

    /**
     * 
     * @return AtaModel
     */
    public function getModel() {
        return $this->model;
    }

    /**
     * 
     * @return LineChartElement
     */
    public function getChart() {
        return $this->chart;
    }

    /**
     * 
     * @return array
     */
    public function getDateRange() {
        return $this->dateRange;
    }

    public function setModel(AtaModel $model) {
        $this->model = $model;
        return $this;
    }

    public function setChart(LineChartElement $chart) {
        $this->chart = $chart;
        return $this;
    }

    public function setDateRange(Array $dateRange) {
        $this->dateRange = $dateRange;
        return $this;
    }

    public function __construct($chartElementName, $model, $dateColumnName = "date") {

        // set the model
        $this->model = $model;

        // create new chart
        $this->chart = new BarChartElement($chartElementName);

        // create date range array
        $this->CreateDayRange();

        // we have to create request for each item
        $chartValues = array();
        foreach ($this->dateRange as $key => $dateRange) {
            $this->dateRange[$key]["value"] = $this->model->count(array("$dateColumnName >= :startdate: AND $dateColumnName <= :enddate: ", "bind" => array(
                    "startdate" => $dateRange["startunix"],
                    "enddate" => $dateRange["endunix"],
            )));
            $chartValues[$key] = $this->dateRange[$key]["value"];
        }

        // now, we have to create chart based on this item
        $this->chart->setValues($chartValues);
    }

    public function CreateDayRange() {

        $lastTime = strtotime("12:00:00");
        $endTime = time();
        for ($index = 0; $index < 31; $index++) {

            // create index
            $this->dateRange[date("m:d", $lastTime)] = array(
                "startunix" => $lastTime,
                "endunix" => $endTime,
                "value" => "",
            );

            // calc last date
            $lastTime = strtotime("-1 day", $lastTime);
            $endTime = strtotime("+1 day", $lastTime);
        }
    }

}
