<?php

class Article extends BaseArticle {

    public function getDate() {
        return Jalali::date("[H:i] Y-m-d", $this->date);
    }

}
