<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use Thumbnail;
use ThumbnailForm;

class ThumbnailController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Thumbnail');
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

        $fr = new ThumbnailForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $thumbnail = new \Thumbnail();

                $thumbnail->originalimageid = $this->request->getPost('originalimageid', 'string');
                $thumbnail->scaleid = $this->request->getPost('scaleid', 'string');
                $thumbnail->outputimageid = $this->request->getPost('outputimageid', 'string');
                if (!$thumbnail->create()) {
                    $thumbnail->showErrorMessages($this);
                } else {
                    $thumbnail->showSuccessMessages($this, 'New Thumbnail added Successfully');

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
        $thumbnails = Thumbnail::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $thumbnails,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Original Image ID','Scale ID','Output Image ID','Date'
                ))->
                setFields(array(
                    'id','originalimageid','scaleid','outputimageid','getDate()'
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
        $item = Thumbnail::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'thumbnail',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Thumbnail::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Thumbnail item');
            } else {
                $this->flash->success('Thumbnail item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'thumbnail',
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
        $this->setTitle('Edit Thumbnail');

        $thumbnailItem = Thumbnail::findFirst($id);

        // create form
        $fr = new ThumbnailForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $thumbnail = Thumbnail::findFirst($id);
                                $thumbnail->originalimageid = $this->request->getPost('originalimageid', 'string');

                                $thumbnail->scaleid = $this->request->getPost('scaleid', 'string');

                                $thumbnail->outputimageid = $this->request->getPost('outputimageid', 'string');

                                $thumbnail->date = $this->request->getPost('date', 'string');
                if (!$thumbnail->save()) {
                    $thumbnail->showErrorMessages($this);
                } else {
                    $thumbnail->showSuccessMessages($this, 'Thumbnail Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('originalimageid')->setDefault($thumbnailItem->originalimageid);
                        $fr->get('scaleid')->setDefault($thumbnailItem->scaleid);
                        $fr->get('outputimageid')->setDefault($thumbnailItem->outputimageid);
                        $fr->get('date')->setDefault($thumbnailItem->date); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Thumbnail::findFirst($id);
        $this->view->item = $item;

        $form = new ThumbnailForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('originalimageid')->setDefault($item->originalimageid);$form->get('scaleid')->setDefault($item->scaleid);$form->get('outputimageid')->setDefault($item->outputimageid);$form->get('date')->setDefault($item->date);$this->view->form = $form;
        
    }

}
