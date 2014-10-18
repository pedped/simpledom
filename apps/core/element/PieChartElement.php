<?php

/**
 * 
 * Uses highcchart
 */
class PieChartElement extends BaseElement {

    
     public function __construct($name, $attributes = null) {
        parent::__construct($name, $attributes);

        // we have to add the javascript and css for the item
        $this->setScriptnames(array(
            "js/highchart/js/highcharts.js"
        ));
    }
    
    
    private $title = "[TITLE]";
    private $seriesName = "[SERIES NAME]";
    private $values = array(
        "x1" => 10,
        "x2" => 30,
        "x3" => 60,
    );

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setValues($values) {
        $this->values = $values;
        return $this;
    }

    public function render($attributes = null) {
        $name = $this->getName();

        $items = array();
        foreach ($this->values as $key => $value) {
            $items[] = "['$key' , $value ]";
        }
        $ys = implode(',', $items);

        $html = "
            <div name='$name' id='$name'>
                
            </div>
            <script>
               $(function () {
                    $('#$name').highcharts({
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: 1,//null,
                            plotShadow: false
                        },
                        title: {
                            text: '$this->title'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                    style: {
                                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                    }
                                }
                            }
                        },
                        series: [{
                            type: 'pie',
                            name: '$this->seriesName',
                            data: [
                                $ys
                            ]
                        }]
                    });
                });          
            </script>
            ";
        return $html;
    }

}
