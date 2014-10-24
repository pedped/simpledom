<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use MelkImage;
use MelkImageForm;

class MelkImageController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('MelkImage');
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

        $fr = new MelkImageForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melkimage = new \MelkImage();

                $melkimage->melkid = $this->request->getPost('melkid', 'string');
                $melkimage->imageid = $this->request->getPost('imageid', 'string');
                $melkimage->date = $this->request->getPost('date', 'string');
                if (!$melkimage->create()) {
                    $melkimage->showErrorMessages($this);
                } else {
                    $melkimage->showSuccessMessages($this, 'New MelkImage added Successfully');

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
        $melkimages = MelkImage::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $melkimages,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Melk ID','Image ID','Date'
                ))->
                setFields(array(
                    'id','melkid','imageid','getDate()'
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
        $item = MelkImage::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'melkimage',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = MelkImage::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this MelkImage item');
            } else {
                $this->flash->success('MelkImage item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'melkimage',
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
        $this->setTitle('Edit MelkImage');

        $melkimageItem = MelkImage::findFirst($id);

        // create form
        $fr = new MelkImageForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melkimage = MelkImage::findFirst($id);
                                $melkimage->melkid = $this->request->getPost('melkid', 'string');

                                $melkimage->imageid = $this->request->getPost('imageid', 'string');

                                $melkimage->date = $this->request->getPost('date', 'string');
                if (!$melkimage->save()) {
                    $melkimage->showErrorMessages($this);
                } else {
                    $melkimage->showSuccessMessages($this, 'MelkImage Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('melkid')->setDefault($melkimageItem->melkid);
                        $fr->get('imageid')->setDefault($melkimageItem->imageid);
                        $fr->get('date')->setDefault($melkimageItem->date); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = MelkImage::findFirst($id);
        $this->view->item = $item;

        $form = new MelkImageForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('melkid')->setDefault($item->melkid);$form->get('imageid')->setDefault($item->imageid);$form->get('date')->setDefault($item->date);$this->view->form = $form;
        
    }

}
