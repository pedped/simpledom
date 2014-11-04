<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use MelkPhoneListnerArea;
use MelkPhoneListnerAreaForm;

class MelkPhoneListnerAreaController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('MelkPhoneListnerArea');
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

        $fr = new MelkPhoneListnerAreaForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melkphonelistnerarea = new \MelkPhoneListnerArea();

                $melkphonelistnerarea->melkphonelistnerid = $this->request->getPost('melkphonelistnerid', 'string');
                $melkphonelistnerarea->areaid = $this->request->getPost('areaid', 'string');
                if (!$melkphonelistnerarea->create()) {
                    $melkphonelistnerarea->showErrorMessages($this);
                } else {
                    $melkphonelistnerarea->showSuccessMessages($this, 'New MelkPhoneListnerArea added Successfully');

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
        $melkphonelistnerareas = MelkPhoneListnerArea::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $melkphonelistnerareas,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Melk Phone Listner ID','Area ID'
                ))->
                setFields(array(
                    'id','melkphonelistnerid','areaid'
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
        $item = MelkPhoneListnerArea::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'melkphonelistnerarea',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = MelkPhoneListnerArea::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this MelkPhoneListnerArea item');
            } else {
                $this->flash->success('MelkPhoneListnerArea item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'melkphonelistnerarea',
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
        $this->setTitle('Edit MelkPhoneListnerArea');

        $melkphonelistnerareaItem = MelkPhoneListnerArea::findFirst($id);

        // create form
        $fr = new MelkPhoneListnerAreaForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melkphonelistnerarea = MelkPhoneListnerArea::findFirst($id);
                                $melkphonelistnerarea->melkphonelistnerid = $this->request->getPost('melkphonelistnerid', 'string');

                                $melkphonelistnerarea->areaid = $this->request->getPost('areaid', 'string');
                if (!$melkphonelistnerarea->save()) {
                    $melkphonelistnerarea->showErrorMessages($this);
                } else {
                    $melkphonelistnerarea->showSuccessMessages($this, 'MelkPhoneListnerArea Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('melkphonelistnerid')->setDefault($melkphonelistnerareaItem->melkphonelistnerid);
                        $fr->get('areaid')->setDefault($melkphonelistnerareaItem->areaid); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = MelkPhoneListnerArea::findFirst($id);
        $this->view->item = $item;

        $form = new MelkPhoneListnerAreaForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('melkphonelistnerid')->setDefault($item->melkphonelistnerid);$form->get('areaid')->setDefault($item->areaid);$this->view->form = $form;
        
    }

}
