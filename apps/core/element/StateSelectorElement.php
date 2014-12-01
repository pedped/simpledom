<?php

use Phalcon\Forms\Element\Select;

/**
 * Uses
 */
class StateSelectorElement extends Select {

    public function render($attributes = null) {
        $html = parent::render($attributes);
        $html.="
                        <script>

            var citiesid = [];
            var cities = [];
            ";
        $cities = City::find();
        foreach ($cities as $city) {

            $html.= 'citiesid[' . $city->id . '] = \'' . $city->name . '\';';
            $ci = $city->getStateCitiesIDWithComma();
            $html.="
                ";
            $html.= 'cities[' . $city->stateid . '] = \'' . $ci . '\';';
            $html.="
                ";
        }



        $html.="function onstatechange(selectedstate)
                    {
                        var ids = cities[selectedstate];
                        var cityids = ids.split(',');
                        // remove old cities
                        var citylisteleemnt = $('#cityid');
                        citylisteleemnt.find('option').remove().end();
                        $.each(cityids, function(index, id) {
                            if (index == 0)
                            {
                                oncitychange(citiesid[id]);
                            }
                            citylisteleemnt.append('<option value=' + id + '>' + citiesid[id] + '</option>');
                        });
                    }

                    function locatteToAddress(address)
                    {
                        geocoder.geocode({'address': address}, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                $('#map_latitude').val(results[0].geometry.location.lat().toFixed(6)).trigger('change');
                                $('#map_longitude').val(results[0].geometry.location.lng().toFixed(6)).trigger('change');
                            } else {
                                alert('Lat and long cannot be found.');
                            }
                        });
                    }

                    function oncitychange(city)
                    {
                        var state = $('#stateid').find('option:selected').text();
                        var address = 'ایران، ' + city;
                        console.log(address);
                        locatteToAddress(address);
                    }

                    $('#stateid').change(function() {
                        onstatechange(this.value);
                    });
                    var addressChangeTimeOut = 0;
                    $('#address').change(function() {

                        clearTimeout(addressChangeTimeOut);
                        addressChangeTimeOut = setTimeout(function() {
                            var city = $('#cityid').find('option:selected').text();
                            var address = $('#address').val();
                            var address = 'ایران، ' + city + '،' + address;
                            console.log(address);
                            locatteToAddress(address);
                        }, 150);
                    });
                    var geocoder = new google.maps.Geocoder();
                    $('#cityid').change(function() {
                        var city = citiesid[$(this).val()];
                        oncitychange(city);
                    });


                </script>
                ";
        return $html;
    }

}
