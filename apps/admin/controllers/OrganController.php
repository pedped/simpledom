<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use Organ;
use OrganForm;

class OrganController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Organ');
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

        $fr = new OrganForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $organ = new \Organ();

                $organ->name = $this->request->getPost('name', 'string');
                $organ->byuserid = $this->request->getPost('byuserid', 'string');
                $organ->address = $this->request->getPost('address', 'string');
                $organ->stateid = $this->request->getPost('stateid', 'string');
                $organ->cityid = $this->request->getPost('cityid', 'string');
                $organ->description = $this->request->getPost('description', 'string');
                $organ->phonenumber = $this->request->getPost('phonenumber', 'string');
                $organ->smscredit = $this->request->getPost('smscredit', 'string');
                $organ->interfaceurl = $this->request->getPost('interfaceurl', 'string');
                $organ->userinterface = $this->request->getPost('userinterface', 'string');
                $organ->status = $this->request->getPost('status', 'string');
                $organ->disablemessage = $this->request->getPost('disablemessage', 'string');
                $organ->date = $this->request->getPost('date', 'string');
                if (!$organ->create()) {
                    $organ->showErrorMessages($this);
                } else {
                    $organ->showSuccessMessages($this, 'New Organ added Successfully');

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
        $organs = Organ::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $organs,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Name','By User','Address','State ID','City ID','Description','Phone Number','SMS Credit','Interface URL','Use Interface','Status','Disable Message','Date'
                ))->
                setFields(array(
                    'id','name','byuserid','address','stateid','cityid','description','phonenumber','smscredit','interfaceurl','userinterface','status','disablemessage','getDate()'
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
        $item = Organ::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'organ',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Organ::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Organ item');
            } else {
                $this->flash->success('Organ item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'organ',
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
        $this->setTitle('Edit Organ');

        $organItem = Organ::findFirst($id);

        // create form
        $fr = new OrganForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $organ = Organ::findFirst($id);
                                $organ->name = $this->request->getPost('name', 'string');

                                $organ->byuserid = $this->request->getPost('byuserid', 'string');

                                $organ->address = $this->request->getPost('address', 'string');

                                $organ->stateid = $this->request->getPost('stateid', 'string');

                                $organ->cityid = $this->request->getPost('cityid', 'string');

                                $organ->description = $this->request->getPost('description', 'string');

                                $organ->phonenumber = $this->request->getPost('phonenumber', 'string');

                                $organ->smscredit = $this->request->getPost('smscredit', 'string');

                                $organ->interfaceurl = $this->request->getPost('interfaceurl', 'string');

                                $organ->userinterface = $this->request->getPost('userinterface', 'string');

                                $organ->status = $this->request->getPost('status', 'string');

                                $organ->disablemessage = $this->request->getPost('disablemessage', 'string');

                                $organ->date = $this->request->getPost('date', 'string');
                if (!$organ->save()) {
                    $organ->showErrorMessages($this);
                } else {
                    $organ->showSuccessMessages($this, 'Organ Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('name')->setDefault($organItem->name);
                        $fr->get('byuserid')->setDefault($organItem->byuserid);
                        $fr->get('address')->setDefault($organItem->address);
                        $fr->get('stateid')->setDefault($organItem->stateid);
                        $fr->get('cityid')->setDefault($organItem->cityid);
                        $fr->get('description')->setDefault($organItem->description);
                        $fr->get('phonenumber')->setDefault($organItem->phonenumber);
                        $fr->get('smscredit')->setDefault($organItem->smscredit);
                        $fr->get('interfaceurl')->setDefault($organItem->interfaceurl);
                        $fr->get('userinterface')->setDefault($organItem->userinterface);
                        $fr->get('status')->setDefault($organItem->status);
                        $fr->get('disablemessage')->setDefault($organItem->disablemessage);
                        $fr->get('date')->setDefault($organItem->date); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Organ::findFirst($id);
        $this->view->item = $item;

        $form = new OrganForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('name')->setDefault($item->name);$form->get('byuserid')->setDefault($item->byuserid);$form->get('address')->setDefault($item->address);$form->get('stateid')->setDefault($item->stateid);$form->get('cityid')->setDefault($item->cityid);$form->get('description')->setDefault($item->description);$form->get('phonenumber')->setDefault($item->phonenumber);$form->get('smscredit')->setDefault($item->smscredit);$form->get('interfaceurl')->setDefault($item->interfaceurl);$form->get('userinterface')->setDefault($item->userinterface);$form->get('status')->setDefault($item->status);$form->get('disablemessage')->setDefault($item->disablemessage);$form->get('date')->setDefault($item->date);$this->view->form = $form;
        
    }

}
