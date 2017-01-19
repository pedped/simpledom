<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use Cachchangereason;
use CachchangereasonForm;
use Simpledom\Admin\BaseControllers\ControllerBase;
use Simpledom\Core\Classes\FileManager;

class CachchangereasonController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('دلایل تغییرات اعتبار');
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

        $fr = new CachchangereasonForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {

                // form is valid
                $cachchangereason = new \Cachchangereason();

                $cachchangereason->name = $this->request->getPost('name', 'string');
                $cachchangereason->description = $this->request->getPost('description', 'string');
                $cachchangereason->increase = $this->request->getPost('increase', 'string');
                $cachchangereason->isgift = $this->request->getPost('isgift', 'string');
                $cachchangereason->amount = $this->request->getPost('amount', 'string');
                if ($this->request->hasFiles() && $this->request->getUploadedFiles()[0]->getSize() > 0) {
                    // valid request, load the files
                    $file = $this->request->getUploadedFiles()[0];
                    $image = FileManager::HandleImageUpload($this->errors, $file, $outputname, $realtiveloaction);
                    if ($image) {
                        // unable to upload file
                        $image->link = $this->url->publicurl . "" . $realtiveloaction;
                        $image->save();

                        $cachchangereason->imageid = $image->id;
                    } else {
                        $this->flash->error("خطا در هنگام ارسال فایل");
                    }
                }


                if (!$cachchangereason->create()) {
                    $cachchangereason->showErrorMessages($this);
                } else {
                    $cachchangereason->showSuccessMessages($this, 'تغییرات اعتبار با موفقیت اضافه گردید');

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
        $cachchangereasons = Cachchangereason::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $cachchangereasons,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'نام', 'توضیحات', 'تاریخ', 'افزایشی', 'هدیه می باشد', 'تصویر'
                ))->
                setFields(array(
                    'id', 'name', 'description', 'getDate()', 'getIncreaseTag()', 'getGiftTag()', 'getImageLinkTag()'
                ))->
                setEditUrl(
                        'cachchangereason/edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'cachchangereason/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function editAction($id) {


        if (!$this->ValidateAccess($id)) {
            // user do not have permission to edut this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        $cachchangereasonItem = Cachchangereason::findFirst($id);

        // create form
        $fr = new CachchangereasonForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $cachchangereason = Cachchangereason::findFirst($id);
                $cachchangereason->name = $this->request->getPost('name', 'string');

                $cachchangereason->description = $this->request->getPost('description', 'string');

//                $cachchangereason->date = $this->request->getPost('date', 'string');

                $cachchangereason->increase = $this->request->getPost('increase', 'string');

                $cachchangereason->isgift = $this->request->getPost('isgift', 'string');

                $cachchangereason->imageid = $this->request->getPost('imageid', 'string');
                
                $cachchangereason->amount = $this->request->getPost('amount', 'string');
                if (!$cachchangereason->save()) {
                    $cachchangereason->showErrorMessages($this);
                } else {
                    $cachchangereason->showSuccessMessages($this, 'ثبت شد');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('name')->setDefault($cachchangereasonItem->name);
            $fr->get('description')->setDefault($cachchangereasonItem->description);
//            $fr->get('date')->setDefault($cachchangereasonItem->date);
            $fr->get('increase')->setDefault($cachchangereasonItem->increase);
            $fr->get('isgift')->setDefault($cachchangereasonItem->isgift);
            $fr->get('imageid')->setDefault($cachchangereasonItem->imageid);
            $fr->get('amount')->setDefault($cachchangereasonItem->amount);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Cachchangereason::findFirst($id);
        $this->view->item = $item;

        $form = new CachchangereasonForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('name')->setDefault($item->name);
        $form->get('description')->setDefault($item->description);
        $form->get('date')->setDefault($item->date);
        $form->get('increase')->setDefault($item->increase);
        $form->get('isgift')->setDefault($item->isgift);
        $form->get('imageid')->setDefault($item->imageid);
        $this->view->form = $form;
    }

}
