<?php

class PriceViewer {

    private $fileds = array();
    private $plans = array();
    private $infos = array();
    private $headerFieldName = "";
    private $purchaseFieldName = "";
    private $priceRowIndex = 0;

    public function getHeaderFieldName() {
        return $this->headerFieldName;
    }

    public function setHeaderFieldName($headerFieldName) {
        $this->headerFieldName = $headerFieldName;
        return $this;
    }

    public function getPlans() {
        return $this->plans;
    }

    public function getInfos() {
        return $this->infos;
    }

    /**
     * 
     * @param type $plans
     * @return PriceViewer
     */
    public function setPlans($plans) {
        $this->plans = $plans;
        return $this;
    }

    /**
     * 
     * @param type $infos
     * @return PriceViewer
     */
    public function setInfos($infos) {
        $this->infos = $infos;
        return $this;
    }

    public function getFileds() {
        return $this->fileds;
    }

    /**
     * 
     * @param type $fileds
     * @return PriceViewer
     */
    public function setFields($fileds) {
        $this->fileds = $fileds;
        return $this;
    }

    public function getPurchaseFieldName() {
        return $this->purchaseFieldName;
    }

    public function getPriceRowIndex() {
        return $this->priceRowIndex;
    }

    public function setSetPurchaseFieldName($setPurchaseFieldName) {
        $this->purchaseFieldName = $setPurchaseFieldName;
        return $this;
    }

    public function setSetPriceRowIndex($setPriceRowIndex) {
        $this->priceRowIndex = $setPriceRowIndex;
        return $this;
    }

    public function Create() {
        $planInfos = "";
        for ($index = 0; $index < count($this->getInfos()); $index++) {
            $value = $this->getInfos()[$index];
            if (intval($this->getPriceRowIndex()) == $index) {
                $planInfos .= "<tr class='price-row'>";
            } else {
                $planInfos .= "<tr>";
            }

            // add name
            $planInfos .= "<td>";
            $planInfos .= $value;
            $planInfos .= "</td>";

            // add values
            foreach ($this->getPlans() as $item) {
                //$value title;
                //$item planItem;
                $planInfos .= "<td>" . $this->getFieldValue($item, $this->getFileds()[$index]) . "</td>";
            }
            $planInfos .= "</tr>";
        }


        $header = $this->getHeader();
        $purchaseButtons = $this->getPurchaseButtons();



        return "<div class='row'>
                    <div class='col-md-12'>
                        <table class='table table-bordered table-responsive table-striped table-price'>
                            <!-- Headers !-->
                            $header
                                
                            <!-- Plans !-->
                            $planInfos
                                
                            <!-- Plans !-->
                            $purchaseButtons
                        </table>
                    </div>
                </div>";
    }

    public function getFieldValue($item, $name) {
        $td = "";
        // add values
        // check if we have to show function or property
        if (strpos($name, "(") == 0) {
            // it is field
            $text = $item->$name;
            $td .= "$text";
        } else {
            // it is function
            $s = strpos($name, "(");
            $text = call_user_func(array($item, substr($name, 0, $s)));
            if (is_bool($text)) {
                if ((boolval($text))) {
                    $td .= "<span class='check-fa fa fa-check'></span>";
                } else {
                    $td.= "<span class='check-fa fa fa-check'></span>";
                }
            } else {
                $td .= "$text";
            }
        }

        return $td;
    }

    public function getHeader() {
        $result = "";
        $result .= "<!-- Headers !-->
                      <tr>
                          <th>
                          </th>";

        foreach ($this->getPlans() as $item) {
            $result .= "<th class='title'>";
            $result .= $this->getFieldValue($item, $this->getHeaderFieldName());
            $result .= "</th>";
        }
        $result .= "</tr>";

        return $result;
    }

    public function getPurchaseButtons() {
        $result = "";
        $result .= "<!-- Purchase Buttons !-->
                      <tr>
                          <th>
                          </th>";

        foreach ($this->getPlans() as $item) {
            $result .= "<th class='purchase-button'>";
            $result .= $this->getFieldValue($item, $this->getPurchaseFieldName());
            $result .= "</th>";
        }
        $result .= "</tr>";

        return $result;
    }

}
