<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use UnsuccessCharge;
use UnsuccessChargeForm;

class UnsuccessChargeController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('UnsuccessCharge');
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

        $fr = new UnsuccessChargeForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $unsuccesscharge = new \UnsuccessCharge();

                $unsuccesscharge->chargeid = $this->request->getPost('chargeid', 'string');
                $unsuccesscharge->value = $this->request->getPost('value', 'string');
                $unsuccesscharge->date = $this->request->getPost('date', 'string');
                if (!$unsuccesscharge->create()) {
                    $unsuccesscharge->showErrorMessages($this);
                } else {
                    $unsuccesscharge->showSuccessMessages($this, 'New UnsuccessCharge added Successfully');

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
        $unsuccesscharges = UnsuccessCharge::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $unsuccesscharges,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Charge ID','Value','Date'
                ))->
                setFields(array(
                    'id','chargeid','value','getDate()'
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
        $item = UnsuccessCharge::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'unsuccesscharge',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = UnsuccessCharge::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this UnsuccessCharge item');
            } else {
                $this->flash->success('UnsuccessCharge item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'unsuccesscharge',
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
        $this->setTitle('Edit UnsuccessCharge');

        $unsuccesschargeItem = UnsuccessCharge::findFirst($id);

        // create form
        $fr = new UnsuccessChargeForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $unsuccesscharge = UnsuccessCharge::findFirst($id);
                                $unsuccesscharge->chargeid = $this->request->getPost('chargeid', 'string');

                                $unsuccesscharge->value = $this->request->getPost('value', 'string');

                                $unsuccesscharge->date = $this->request->getPost('date', 'string');
                if (!$unsuccesscharge->save()) {
                    $unsuccesscharge->showErrorMessages($this);
                } else {
                    $unsuccesscharge->showSuccessMessages($this, 'UnsuccessCharge Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('chargeid')->setDefault($unsuccesschargeItem->chargeid);
                        $fr->get('value')->setDefault($unsuccesschargeItem->value);
                        $fr->get('date')->setDefault($unsuccesschargeItem->date); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = UnsuccessCharge::findFirst($id);
        $this->view->item = $item;

        $form = new UnsuccessChargeForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('chargeid')->setDefault($item->chargeid);$form->get('value')->setDefault($item->value);$form->get('date')->setDefault($item->date);$this->view->form = $form;
        
    }

}
