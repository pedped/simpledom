<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use BongahImage;
use BongahImageForm;
use Simpledom\Admin\BaseControllers\ControllerBase;

class BongahImageController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('BongahImage');
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

        $fr = new BongahImageForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongahimage = new \BongahImage();

                $bongahimage->bongahid = $this->request->getPost('bongahid', 'string');
                $bongahimage->imageid = $this->request->getPost('imageid', 'string');
                $bongahimage->delete = $this->request->getPost('delete', 'string');
                if (!$bongahimage->create()) {
                    $bongahimage->showErrorMessages($this);
                } else {
                    $bongahimage->showSuccessMessages($this, 'New BongahImage added Successfully');

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
        $bongahimages = BongahImage::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $bongahimages,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Bongah ID', 'Image ID', 'Delete'
                ))->
                setFields(array(
                    'id', 'bongahid', 'imageid', 'delete'
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
        $item = BongahImage::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'bongahimage',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = BongahImage::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this BongahImage item');
            } else {
                $this->flash->success('BongahImage item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'bongahimage',
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
        $this->setTitle('Edit BongahImage');

        $bongahimageItem = BongahImage::findFirst($id);

        // create form
        $fr = new BongahImageForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongahimage = BongahImage::findFirst($id);
                $bongahimage->bongahid = $this->request->getPost('bongahid', 'string');

                $bongahimage->imageid = $this->request->getPost('imageid', 'string');

                $bongahimage->delete = $this->request->getPost('delete', 'string');
                if (!$bongahimage->save()) {
                    $bongahimage->showErrorMessages($this);
                } else {
                    $bongahimage->showSuccessMessages($this, 'BongahImage Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('bongahid')->setDefault($bongahimageItem->bongahid);
            $fr->get('imageid')->setDefault($bongahimageItem->imageid);
            $fr->get('delete')->setDefault($bongahimageItem->delete);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = BongahImage::findFirst($id);
        $this->view->item = $item;

        $form = new BongahImageForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('bongahid')->setDefault($item->bongahid);
        $form->get('imageid')->setDefault($item->imageid);
        $form->get('delete')->setDefault($item->delete);
        $this->view->form = $form;
    }

}
