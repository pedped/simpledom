<?php

use Simpledom\Core\AtaModel;

/**
 * this model will create a chart element for the model based on date field ( unix field )
 *
 * @author ataalla
 */
class ModelChart
{

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


    private $usepersiandate = false;

    /**
     *
     * @return AtaModel
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     *
     * @return LineChartElement
     */
    public function getChart()
    {
        return $this->chart;
    }

    /**
     *
     * @return array
     */
    public function getDateRange()
    {
        return $this->dateRange;
    }

    public function setModel(AtaModel $model)
    {
        $this->model = $model;
        return $this;
    }

    public function setChart($chart)
    {
        $this->chart = $chart;
        return $this;
    }

    public function setDateRange(Array $dateRange)
    {
        $this->dateRange = $dateRange;
        return $this;
    }


    public function __construct($chartElementName, $model = null, $dateColumnName = "date")
    {

        // create new chart
        $this->chart = new LineChartElement($chartElementName);

        if (isset($model)) {
            // set the model
            $this->model = $model;

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
    }

    public function SetModelQuery($model, $queryArray = array(), $dateColumnName = "date", $usepersiandate = false)
    {

        // set the model
        $this->model = $model;

        // set date
        $this->usepersiandate = $usepersiandate;

        // create date range array
        $this->CreateDayRange();

        // add bidn array
        // we have to create request for each item
        $chartValues = array();
        foreach ($this->dateRange as $key => $dateRange) {

            // we have to search for valid item
            $bindArray = array();
            if (isset($queryArray["bind"]))
                $bindArray = $queryArray["bind"];

            $bindArray["startdate"] = $dateRange["startunix"];
            $bindArray["enddate"] = $dateRange["endunix"];

            $query = "";
            if (count($queryArray) > 0 && isset($queryArray[0]) && is_string($queryArray[0])) {
                $query = $queryArray[0];
                $query .= "AND ";
            }

            $query .= "$dateColumnName >= :startdate: AND $dateColumnName <= :enddate:";

            // create request item
            $items = array($query, "bind" => $bindArray);
            if (isset($queryArray["group"])) {
                $items["group"] = $queryArray["group"];
//                $items["distinct"] = "userids";

                $this->dateRange[$key]["value"] = $this->model->count($items)->count();
            } else if (isset($queryArray["sumcolumn"])) {
                $items["column"] = $queryArray["sumcolumn"];
                $sum = $this->model->sum($items);
                $this->dateRange[$key]["value"] = isset($sum) ? $sum : 0;

            } else {
                $this->dateRange[$key]["value"] = $this->model->count($items);
            }



            $chartValues[$key] = $this->dateRange[$key]["value"];
        }


        // now, we have to create chart based on this item
        $this->chart->setValues($chartValues);
    }

    public function CreateDayRange()
    {

        $lastTime = strtotime("0:00:00");
        $endTime = time();
        for ($index = 0; $index < 31; $index++) {

            // create index
            if ($this->usepersiandate) {

                // we have to use persian date for time
                $this->dateRange[Jalali::date("y/m/d", $lastTime)] = array(
                    "startunix" => $lastTime,
                    "endunix" => $endTime,
                    "value" => "",
                );
            } else {

                // we have to use native date for user
                $this->dateRange[date("m/d", $lastTime)] = array(
                    "startunix" => $lastTime,
                    "endunix" => $endTime,
                    "value" => "",
                );
            }

            // calc last date
            $lastTime = strtotime("-1 day", $lastTime);
            $endTime = strtotime("+1 day", $lastTime);
        }

        // reverse the array
        $this->dateRange = array_reverse($this->dateRange);
    }

}
