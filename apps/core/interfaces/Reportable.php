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
interface Reportable {

    public function GetReportReason();

    public function Report();

    public function GetReportCount();

    public function GetReportType();

    public function GetReportItemID();
}
