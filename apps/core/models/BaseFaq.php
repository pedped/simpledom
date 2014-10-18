<?php

use Simpledom\Core\AtaModel;

class BaseFaq extends AtaModel {

    public function getSource() {
        return "faq";
    }

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $head;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *
     * @var string
     */
    public $message;

    public function getPublicResponse() {
        
    }

    public function getItems() {
        return BaseFaq::find(
                        array(
                            "head = '$this->head'",
                            "order" => "id DESC"
        ));
    }

}
