<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author pedram
 */
interface Searchable {

    public static function RequestSearch($query, $start, $limit, &$foundedCount = -1, &$results = array(), &$viewName = "default");
}
