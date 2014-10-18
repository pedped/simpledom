<?php

/**
 * 
 * Uses CKEDITOR
 */
class LineChartElement extends BaseElement {

    public function __construct($name, $attributes = null) {
        parent::__construct($name, $attributes);

        // we have to add the javascript and css for the item
        $this->setScriptnames(array(
            "js/highchart/js/highcharts.js"
        ));
    }

    private $title = "[TITLE]";
    private $subtitle = "[SUBTITLE]";
    private $yAxis = "[YAXIS]";
    private $xName = "[XNAME]";
    private $values = array(
        "x1" => 0,
        "x2" => 10,
        "x3" => 20,
    );

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setSubtitle($subtitle) {
        $this->subtitle = $subtitle;
        return $this;
    }

    public function setYAxis($yAxis) {
        $this->yAxis = $yAxis;
        return $this;
    }

    public function setXName($xName) {
        $this->xName = $xName;
        return $this;
    }

    public function setValues($values) {
        $this->values = $values;
        return $this;
    }

    public function render($attributes = null) {
        $name = $this->getName();

        $keys = array();
        foreach ($this->values as $key => $value) {
            $keys[] = "'$key'";
        }
        $xs = implode(',', array_values($keys));
        $ys = implode(',', array_values($this->values));

        $html = "
            <div name='$name' id='$name'>
                
            </div>
            <script>
                $(function () {
                    $('#$name').highcharts({
                        chart: {
                            type: 'line'
                        },
                        title: {
                            text: '$this->title'
                        },
                        subtitle: {
                            text: '$this->subtitle'
                        },
                        xAxis: {
                            categories: [$xs]
                        },
                        yAxis: {
                            title: {
                                text: '$this->yAxis'
                            }
                        },
                        plotOptions: {
                            line: {
                                dataLabels: {
                                    enabled: true
                                },
                                enableMouseTracking: false
                            }
                        },
                        series: [{
                            name: '$this->xName',
                            data: [$ys]
                        }]
                    });
                });            
            </script>
            ";
        return $html;
    }

}
