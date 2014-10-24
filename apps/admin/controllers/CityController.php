<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use City;
use CityForm;

class CityController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('City');
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

        $fr = new CityForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $city = new \City();

                $city->stateid = $this->request->getPost('stateid', 'string');
                $city->name = $this->request->getPost('name', 'string');
                if (!$city->create()) {
                    $city->showErrorMessages($this);
                } else {
                    $city->showSuccessMessages($this, 'New City added Successfully');

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

    public function listAction($page = 1) {

        // load the users
        $citys = City::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $citys,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','State ID','Name'
                ))->
                setFields(array(
                    'id','stateid','name'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = City::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'city',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = City::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this City item');
            } else {
                $this->flash->success('City item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'city',
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
        $this->setTitle('Edit City');

        $cityItem = City::findFirst($id);

        // create form
        $fr = new CityForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $city = City::findFirst($id);
                                $city->stateid = $this->request->getPost('stateid', 'string');

                                $city->name = $this->request->getPost('name', 'string');
                if (!$city->save()) {
                    $city->showErrorMessages($this);
                } else {
                    $city->showSuccessMessages($this, 'City Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('stateid')->setDefault($cityItem->stateid);
                        $fr->get('name')->setDefault($cityItem->name); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = City::findFirst($id);
        $this->view->item = $item;

        $form = new CityForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('stateid')->setDefault($item->stateid);$form->get('name')->setDefault($item->name);$this->view->form = $form;
        
    }

}
