<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use BarChartElement;
use BaseSearchHistory;
use Simpledom\Core\AtaForm;
use Simpledom\Core\SiteForms\SearchHistoryForm;

class SearchHistoryControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('SearchHistory');
    }

    /**
     * this function will validate request access
     * @param type $id
     * @return boolean
     */
    protected function ValidateAccess($id) {
        return true;
    }

    public function addAction() {

        $fr = new SearchHistoryForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $searchhistory = new \SearchHistory();

                $searchhistory->userid = $this->request->getPost('userid', 'string');
                $searchhistory->query = $this->request->getPost('query', 'string');
                $searchhistory->date = $this->request->getPost('date', 'string');
                if (!$searchhistory->create()) {
                    $searchhistory->showErrorMessages($this);
                } else {
                    $searchhistory->showSuccessMessages($this, 'New SearchHistory added Successfully');

                    // clear the title and message so the user can add better info
                    $fr->clear();
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }
        $this->view->form = $fr;
    }

    public function mostAction($page = 1, $pastday = 30) {

        $time = time() - ($pastday * 3600 * 24);
        // load the users
        $searchhistorys = BaseSearchHistory::find(
                        array(
                            "date > $time",
                            "columns" => "count(id) as count , id , userid , query",
                            'group' => "query",
                            'order' => 'id DESC',
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $searchhistorys,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'Query', 'Count'
                ))->
                setFields(array(
                    'query', 'count'
                ))->setListPath(
                'searchhisotry/most/{pn}/' . $pastday);

        $this->view->list = $paginator->getPaginate();
        $this->view->day = $pastday;
        $this->loadChart($searchhistorys->toArray());
    }

    public function loadChart($values) {

        $items = array();
        foreach ($values as $value) {
            $items[$value["query"]] = (int) $value["count"];
        }

        // create new form
        $form = new AtaForm();

        // load chart box
        // fetch data
        $chartlement = new BarChartElement("chart");
        $chartlement->setTitle("Most Search Queries");
        $chartlement->setSubtitle("You can see most search quires during your selected periods");
        $chartlement->setXName("Query");
        $chartlement->setYAxis("Count");
        $chartlement->setValues($items);
        $chartlement->setTooltip(" Searchs");

        // add element to form
        $form->add($chartlement);

        // set view form
        $this->view->form = $form;
        $this->handleFormScripts($form);
    }

    public function listAction($page = 1) {

        // load the users
        $searchhistorys = BaseSearchHistory::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $searchhistorys,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'User ID', 'Query', 'Date'
                ))->
                setFields(array(
                    'id', 'userid', 'query', 'getDate()'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'searchhistory/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = BaseSearchHistory::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'searchhistory',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = BaseSearchHistory::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this SearchHistory item');
            } else {
                $this->flash->success('SearchHistory item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'searchhistory',
                            'action' => 'list'
                ));
            }
        }
    }

    public function editAction($id) {


        if (!$this->ValidateAccess($id)) {
            // user do not have permission to edut this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // set title
        $this->setTitle('Edit SearchHistory');

        $searchhistoryItem = BaseSearchHistory::findFirst($id);

        // create form
        $fr = new SearchHistoryForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $searchhistory = BaseSearchHistory::findFirst($id);
                $searchhistory->userid = $this->request->getPost('userid', 'string');

                $searchhistory->query = $this->request->getPost('query', 'string');

                $searchhistory->date = $this->request->getPost('date', 'string');
                if (!$searchhistory->save()) {
                    $searchhistory->showErrorMessages($this);
                } else {
                    $searchhistory->showSuccessMessages($this, 'SearchHistory Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values
            $fr->get('userid')->setDefault($searchhistoryItem->userid);
            $fr->get('query')->setDefault($searchhistoryItem->query);
            $fr->get('date')->setDefault($searchhistoryItem->date);
        }
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = BaseSearchHistory::findFirst($id);
        $this->view->item = $item;

        $form = new SearchHistoryForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('query')->setDefault($item->query);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
