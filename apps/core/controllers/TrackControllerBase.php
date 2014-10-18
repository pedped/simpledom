<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use BaseLogins;
use BaseTrack;

class TrackControllerBase extends ControllerBase {

    public function indexAction() {
        $this->setTitle("Tracks");
    }

    public function viewvisitAction($id) {
        // set title
        $this->setTitle("View Visit");

        // Load Track
        $this->view->track = BaseTrack::findFirst($id);
    }

    public function visitsAction() {

        // set title
        $this->setTitle("Visitors");

        // load the visits count
        $tr = new BaseTrack();
        $this->view->totalVisits = BaseTrack::count();
        $this->view->last7DayVisits = $tr->getLastSevenDaysVistCount();

        $this->view->visits = $tr->getLastMonthVisitChart();

        // Load Last 100 Visits
        $this->view->last100Tracks = BaseTrack::find(array(
                    "limit" => "100",
                    "order" => "id DESC"
        ));
    }

    public function loginAction($page = 1) {
        // set logins
        $this->setTitle("Logins");

        // load the users
        $logins = BaseLogins::find();

        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            "data" => $logins,
            "limit" => 30,
            "page" => $numberPage
        ));
        $this->view->users = $paginator->getPaginate();
    }

    protected function ValidateAccess($id) {
        
    }

    public function uservisitsAction($userid, $page = 1) {

        $this->setTitle("User Visits");

        // load the users
        $logins = \BaseTrack::find(
                        array(
                            "userid = '$userid'",
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $logins,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Name', 'Date', 'IP', 'Agent'
                ))->
                setFields(array(
                    'id', 'getUserName()', 'getDate()', 'ip', 'agent'
                ))->
                setEditUrl(
                        'view'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'list');

        $this->view->list = $paginator->getPaginate();
    }

}
