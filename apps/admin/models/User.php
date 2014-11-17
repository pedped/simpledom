<?php

class User extends BaseUser {

    public function beforeValidationOnCreate() {
        parent::beforeValidationOnCreate();
        $this->questioncanask = "0";
    }

}
