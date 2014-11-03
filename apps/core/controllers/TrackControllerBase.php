<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use BaseLogins;
use BaseTrack;
use LineChartElement;
use Simpledom\Core\AtaForm;

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

    private function loadRegisterChart($baseTrack) {

        // create new form
        $form = new AtaForm();
        $values = $baseTrack->getLastMonthVisitChart()->toArray();
        $chartItems = array();
        foreach ($values as $value) {
            $chartItems[$value["year"] . "/" . $value["month"] . "/" . $value["day"]] = $value["total"];
        }

        // load chart box
        // fetch data
        $chartlement = new LineChartElement("visitchart");
        $chartlement->setTitle("Track Visitors");
        $chartlement->setSubtitle("this chart shows each day visit during last 30 days");
        $chartlement->setXName("Date");
        $chartlement->setYAxis("Count");
        $chartlement->setValues($chartItems);

        // add element to form
        $form->add($chartlement);

        // set view form
        $this->view->form = $form;
        $this->handleFormScripts($form);
    }

    public function visitsAction() {

        // set title
        $this->setTitle("Visitors");

        // load the visits count
        $tr = new BaseTrack();
        $this->view->totalVisits = BaseTrack::count();
        $this->view->last7DayVisits = $tr->getLastSevenDaysVistCount();
        $this->loadRegisterChart($tr);

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
                'track/list');

        $this->view->list = $paginator->getPaginate();
    }

}
