<?php

use Simpledom\Core\AtaModel;

class BaseTrack extends AtaModel {

    /**
     * QUERY TO FETCH LAST MONTH VISITS
     * SELECT day(time) , count(*) FROM `track` WHERE YEAR(`time`) >= YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
      AND MONTH(`time`) >= MONTH(CURRENT_DATE - INTERVAL 1 MONTH) GROUP BY day(time)
     */
    public function getSource() {
        return "track";
    }

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $userid;

    /**
     *
     * @var integer
     */
    public $ip;

    /**
     *
     * @var integer
     */
    public $url;

    /**
     *
     * @var integer
     */
    public $date;

    /**
     *
     * @var string
     */
    public $agent;

    /**
     *
     * @var string
     */
    public $time;

    /**
     *
     * @var string
     */
    public $parameters;

    public function hasUser() {
        return isset($this->userid) && intval($this->userid) > 0;
    }

    /**
     * Fetch the user who visited the page
     * @return BaseUser
     */
    public function getUser() {
        return BaseUser::findFirst($this->userid);
    }

    /**
     * return the full name of the user
     * @return type
     */
    public function getUserName() {
        return BaseUser::findFirst($this->userid)->getFullName();
    }

    public function getDate() {
        return date("Y-m-d H:i:s", $this->date);
    }

    public function beforeValidationOnCreate() {
        $this->time = date("Y-m-d H:i:s", time());
        $this->date = time();
    }

    public function getLastMonthVisitChart() {

        return $this->rawQuery("SELECT  YEAR(track.time) as year , MONTH(track.time) as month , day(track.time) as day , count(track.userid) as total FROM `track` WHERE YEAR(track.time) >= YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
AND MONTH(track.time) >= MONTH(CURRENT_DATE - INTERVAL 1 MONTH) GROUP BY day(track.time)");
    }

    public function getLastSevenDaysVistCount() {
        return $this->rawQuery("SELECT  COUNT(*) as total FROM `track` WHERE YEAR(track.time) >= YEAR(CURRENT_DATE - INTERVAL 1 DAY)
AND MONTH(track.time) >= MONTH(CURRENT_DATE - INTERVAL 1 DAY) AND DAY(track.time) >= DAY(CURRENT_DATE - INTERVAL 1 DAY)");
    }

    public function getPublicResponse() {
        $item = new stdClass();
        $item->id = $this->id;
        $item->agent = $this->agent;
        $item->date = $this->date;
        return $item;
    }

}
