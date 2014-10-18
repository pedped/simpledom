<?php

/**
 * 
 * Uses CKEDITOR
 */
class AreaChartElement extends BaseElement {

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
    private $valueSuffix = "[VALUE SUFFIX]";
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

    public function setValueSuffix($valueSuffix) {
        $this->valueSuffix = $valueSuffix;
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
                            type: 'area'
                        },
                        title: {
                            text: '$this->title'
                        },
                        subtitle: {
                            text: '$this->subtitle'
                        },
                        xAxis: {
                            categories: ['1750', '1800', '1850', '1900', '1950', '1999', '2050'],
                            tickmarkPlacement: 'on',
                            title: {
                                enabled: false
                            }
                        },
                        yAxis: {
                            title: {
                                text: 'Billions'
                            },
                            labels: {
                                formatter: function () {
                                    return this.value / 1000;
                                }
                            }
                        },
                        tooltip: {
                            shared: true,
                            valueSuffix: ' $this->valueSuffix'
                        },
                        plotOptions: {
                            area: {
                                stacking: 'normal',
                                marker: {
                                    lineWidth: 1,
                                    lineColor: '#666666'
                                }
                            }
                        },
                        series: [{
                            name: 'Asia',
                            data: [502, 635, 809, 947, 1402, 3634, 5268]
                        }, {
                            name: 'Africa',
                            data: [106, 107, 111, 133, 221, 767, 1766]
                        }, {
                            name: 'Europe',
                            data: [163, 203, 276, 408, 547, 729, 628]
                        }, {
                            name: 'America',
                            data: [18, 31, 54, 156, 339, 818, 1201]
                        }, {
                            name: 'Oceania',
                            data: [2, 2, 2, 6, 13, 30, 46]
                        }]
                    });
                });
            </script>
            ";
        return $html;
    }

}
