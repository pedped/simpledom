<?php

class Opinion extends BaseOpinion {

    //put your code here
    public static $DateValues = array(
        1 => "1",
        2 => "2",
        3 => "3",
        4 => "4",
        5 => "5",
    );

    public function getDate() {
        return Jalali::date("Y-m-d", $this->date);
    }

}
