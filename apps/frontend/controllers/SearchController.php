<?php

namespace Simpledom\Frontend\Controllers;

use AtaPaginator;
use BaseSearchHistory;
use BaseUser;
use Simpledom\Frontend\Controllers\ControllerBase;
use stdClass;

class SearchController extends ControllerBase {

    public function requestAction($pageNumber = 1, $type = "all") {

        // check for currect page number
        if ($pageNumber < 1) {
            return;
        }

        $results = new stdClass();
        $query = $this->request->getQuery("query", "string");
        $start = intval(($pageNumber * 10) - 10);
        switch ($type) {
            case "all":
                $results = $this->searchAll($query, $start);
                break;
        }

        // log the search request
        if ($pageNumber == 1) {
            $searchRequest = new BaseSearchHistory();
            $searchRequest->query = $query;
            $searchRequest->userid = $this->session->has("userid") ? $this->session->get("userid") : null;
            $searchRequest->create();
        }
        // create paginatior and send result
        // load the users

        $numberPage = $pageNumber;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $results->items,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'User ID', 'Name',
                ))->
                setFields(array(
                    'userid', 'fullname',
                ))
                ->setListPath(
                        'list');

        $this->view->list = $paginator->getPaginate();
        $this->view->result = $results;

        // set page title
        $this->setPageTitle("Search For $query");
    }

    public function searchAll($query, $start) {
        // search users
        return BaseUser::RequestSearch($query, $start, 16);
    }

}
