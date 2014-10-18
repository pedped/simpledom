<?php

namespace Simpledom\Core\Classes;
interface SMSProviderInterface {

    static function getRemain();

    static function isDelivered($referneceCode);
}
