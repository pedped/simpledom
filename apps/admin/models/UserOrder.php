<?php

class UserOrder extends BaseUserOrder {

    public function getPhone() {
        return User::findWithUserID($this->userid)->getVerifiedPhone();
    }

}
