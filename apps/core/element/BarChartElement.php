<?php

/**
 * 
 * Uses CKEDITOR
 */
class BarChartElement extends BaseElement {

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
    private $toolTip = "[TOOLTIP]";
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

    public function setTooltip($tooltip) {
        $this->toolTip = $tooltip;
        return $this;
    }

    public function render($attributes = null) {
        $name = $this->getName();

        $keys = array();
        foreach ($this->values as $key => $value) {
            $keys[] = "['$key' , $value ]";
        }
        $ys = implode(',', array_values($keys));

        $html = "
            <div name='$name' id='$name'>
                
            </div>
            <script>
                $(function () {
                    $('#$name').highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: '$this->title'
                        },
                        subtitle: {
                            text: '$this->subtitle'
                        },
                        xAxis: {
                            type: 'category',
                            labels: {
                                rotation: -45,
                                style: {
                                    fontSize: '13px',
                                    fontFamily: 'Verdana, sans-serif'
                                }
                            }
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: '$this->yAxis'
                            }
                        },
                        legend: {
                            enabled: false
                        },
                        tooltip: {
                            shared: true,
                            valueSuffix: '$this->toolTip'
                        },
                        series: [{
                            name: 'Count',
                            data: [$ys],
                            dataLabels: {
                                enabled: true,
                                rotation: -90,
                                color: '#FFFFFF',
                                align: 'right',
                                x: 4,
                                y: 10,
                                style: {
                                    fontSize: '13px',
                                    fontFamily: 'Verdana, sans-serif',
                                    textShadow: '0 0 3px black'
                                }
                            }
                        }]
                    });
                });
            </script>
            ";
        return $html;
    }

}
