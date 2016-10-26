<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use BaseImage;
use Simpledom\Core\Classes\FileManager;
use Simpledom\Core\ImageForm;
use Simpledom\Core\UploadImageForm;

class ImageControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Image');
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

        $fr = new ImageForm();
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $image = new \Image();

                $image->path = $this->request->getPost('path', 'string');
                $image->date = $this->request->getPost('date', 'string');
                $image->mimetype = $this->request->getPost('mimetype', 'string');
                $image->filesize = $this->request->getPost('filesize', 'string');
                if (!$image->create()) {
                    $image->showErrorMessages($this);
                } else {
                    $image->showSuccessMessages($this, 'New Image added Successfully');

                    // clear the title and message so the user can add better info
                    $fr->clear();
                }
            } else {
                // invalid
            }
        }
        $this->view->form = $fr;
    }

    public function uploadAction() {
        $fr = new UploadImageForm();
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                if ($this->request->hasFiles()) {
                    // valid request, load the files
                    foreach ($this->request->getUploadedFiles() as $file) {
                        $image = FileManager::HandleImageUpload($this->errors, $file, $outputname, $realtiveloaction);
                        if (!$image) {
                            // unable to upload file
                            $image->link = $this->url->publicurl . "" . $realtiveloaction;
                            $image->save();
                        } else {

                            $this->flash->success("Image Uploaded Successfully");
                        }
                    }
                } else {
                    $this->flash->error("You have to choose the file");
                }
            } else {
                // invalid posts
                $this->flash->error("Invalid Form Datas");
            }
        }
        $this->view->form = $fr;
    }

    public function listAction($page = 1) {


        // load the users
        $images = \Image::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $images,
            'limit' => 3,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Image', 'Date', 'Mime Type', 'File Size'
                ))->
                setFields(array(
                    'id', 'getImageElement()', 'getDate()', 'mimetype', 'getHumanSize()'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'image/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = BaseImage::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'image',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = BaseImage::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Image item');
            } else {
                $this->flash->success('Image item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'image',
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
        $this->setTitle('Edit Image');

        $imageItem = BaseImage::findFirst($id);

        // create form
        $fr = new ImageForm();

        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $image = BaseImage::findFirst($id);
                $image->path = $this->request->getPost('path', 'string');

                $image->date = $this->request->getPost('date', 'string');

                $image->mimetype = $this->request->getPost('mimetype', 'string');

                $image->filesize = $this->request->getPost('filesize', 'string');
                if (!$image->save()) {
                    $image->showErrorMessages($this);
                } else {
                    $image->showSuccessMessages($this, 'Image Saved Successfully');
                }
            } else {
                // invalid
            }
        } else {
            // set default values
            $fr->get('path')->setDefault($imageItem->path);
            $fr->get('date')->setDefault($imageItem->date);
            $fr->get('mimetype')->setDefault($imageItem->mimetype);
            $fr->get('filesize')->setDefault($imageItem->filesize);
            $fr->get('image')->setHref($imageItem->link);
        }
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = BaseImage::findFirst($id);
        $this->view->item = $item;

        $form = new ImageForm();
        $form->get('id')->setDefault($item->id);
        $form->get('path')->setDefault($item->path);
        $form->get('date')->setDefault($item->date);
        $form->get('mimetype')->setDefault($item->mimetype);
        $form->get('filesize')->setDefault($item->filesize);
        $this->view->form = $form;
    }

}
