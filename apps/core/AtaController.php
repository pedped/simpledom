<?php

use Phalcon\Mvc\Controller;

abstract class AtaController extends Controller {

    /**
     * this function will validate read, delete, remove, Saccess
     */
    protected abstract function ValidateAccess($id);
}
