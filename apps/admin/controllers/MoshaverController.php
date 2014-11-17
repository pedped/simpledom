<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use Moshaver;
use MoshaverForm;

class MoshaverController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Moshaver');
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

        $fr = new MoshaverForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $moshaver = new \Moshaver();

                $moshaver->userid = $this->request->getPost('userid', 'string');
                $moshaver->cityid = $this->request->getPost('cityid', 'string');
                $moshaver->address = $this->request->getPost('address', 'string');
                $moshaver->phone = $this->request->getPost('phone', 'string');
                $moshaver->verified = $this->request->getPost('verified', 'string');
                $moshaver->moshavertypeid = $this->request->getPost('moshavertypeid', 'string');
                $moshaver->degreetypeid = $this->request->getPost('degreetypeid', 'string');
                $moshaver->info = $this->request->getPost('info', 'string');
                $moshaver->status = $this->request->getPost('status', 'string');
                $moshaver->date = $this->request->getPost('date', 'string');
                if (!$moshaver->create()) {
                    $moshaver->showErrorMessages($this);
                } else {
                    $moshaver->showSuccessMessages($this, 'New Moshaver added Successfully');

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
        $moshavers = Moshaver::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $moshavers,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','User ID','City ID','Address','Phone','Verified','Moshaver Type','Degree Type','Info','Status','Date'
                ))->
                setFields(array(
                    'id','userid','cityid','address','phone','verified','moshavertypeid','degreetypeid','info','status','getDate()'
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
        $item = Moshaver::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'moshaver',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Moshaver::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Moshaver item');
            } else {
                $this->flash->success('Moshaver item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'moshaver',
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
        $this->setTitle('Edit Moshaver');

        $moshaverItem = Moshaver::findFirst($id);

        // create form
        $fr = new MoshaverForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $moshaver = Moshaver::findFirst($id);
                                $moshaver->userid = $this->request->getPost('userid', 'string');

                                $moshaver->cityid = $this->request->getPost('cityid', 'string');

                                $moshaver->address = $this->request->getPost('address', 'string');

                                $moshaver->phone = $this->request->getPost('phone', 'string');

                                $moshaver->verified = $this->request->getPost('verified', 'string');

                                $moshaver->moshavertypeid = $this->request->getPost('moshavertypeid', 'string');

                                $moshaver->degreetypeid = $this->request->getPost('degreetypeid', 'string');

                                $moshaver->info = $this->request->getPost('info', 'string');

                                $moshaver->status = $this->request->getPost('status', 'string');

                                $moshaver->date = $this->request->getPost('date', 'string');
                if (!$moshaver->save()) {
                    $moshaver->showErrorMessages($this);
                } else {
                    $moshaver->showSuccessMessages($this, 'Moshaver Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('userid')->setDefault($moshaverItem->userid);
                        $fr->get('cityid')->setDefault($moshaverItem->cityid);
                        $fr->get('address')->setDefault($moshaverItem->address);
                        $fr->get('phone')->setDefault($moshaverItem->phone);
                        $fr->get('verified')->setDefault($moshaverItem->verified);
                        $fr->get('moshavertypeid')->setDefault($moshaverItem->moshavertypeid);
                        $fr->get('degreetypeid')->setDefault($moshaverItem->degreetypeid);
                        $fr->get('info')->setDefault($moshaverItem->info);
                        $fr->get('status')->setDefault($moshaverItem->status);
                        $fr->get('date')->setDefault($moshaverItem->date); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Moshaver::findFirst($id);
        $this->view->item = $item;

        $form = new MoshaverForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('userid')->setDefault($item->userid);$form->get('cityid')->setDefault($item->cityid);$form->get('address')->setDefault($item->address);$form->get('phone')->setDefault($item->phone);$form->get('verified')->setDefault($item->verified);$form->get('moshavertypeid')->setDefault($item->moshavertypeid);$form->get('degreetypeid')->setDefault($item->degreetypeid);$form->get('info')->setDefault($item->info);$form->get('status')->setDefault($item->status);$form->get('date')->setDefault($item->date);$this->view->form = $form;
        
    }

}
