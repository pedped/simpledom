<?php

class Article extends BaseArticle {

    public function getDate() {
        return Jalali::date("[H:i] Y-m-d", $this->date);
    }

    /**
     * 
     * @return User
     */
    public function getUser() {
        return User::findFirst(array("userid = :userid:", "bind" => array("userid" => $this->userid)));
    }

}
