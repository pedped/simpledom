<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Admin\BaseControllers\ControllerBase;
use Simpledom\Core\Classes\FileManager;
use Simpledom\Core\Classes\Helper;
use User;
use Worker;
use WorkerForm;

class WorkerController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('کارمندان');
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

        $fr = new WorkerForm();

        // request add password
        $fr->get("password")->addValidator(new PresenceOf(array(
        )));

        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $worker = new \Worker();


                // find password
                $password = $this->request->getPost('password', 'string');
                $worker->firstname = $this->request->getPost('firstname', 'string');
                $worker->lastname = $this->request->getPost('lastname', 'string');
                $worker->gender = $this->request->getPost('gender', 'string');
                $user = new User();
                $result = $user->registerAccount($this, $this->errors, $worker->firstname, $worker->lastname, $worker->gender, Helper::GenerateRandomString(32) . "@gmail.com", $password, USERLEVEL_WORKER);
                if ($result == TRUE) {
                    $worker->userid = $user->userid;
                    $worker->fathername = $this->request->getPost('fathername', 'string');
                    $worker->identitynumber = $this->request->getPost('identitynumber', 'string');
                    $worker->birthday = $this->request->getPost('birthday', 'string');
                    $worker->workersectionid = $this->request->getPost('workersectionid', 'string');
                    $worker->address = $this->request->getPost('address', 'string');
                    $worker->phone = $this->request->getPost('phone', 'string');
                    $worker->mobile = $this->request->getPost('mobile', 'string');
                    $worker->status = $this->request->getPost('status', 'string');
                    if (!$worker->create()) {
                        $worker->showErrorMessages($this);
                    } else {
                        $worker->showSuccessMessages($this, 'کارمند جدید با موفقیت اضافه گردید');

                        // clear the title and message so the user can add better info
                        $fr->clear();
                    }
                } else {
                    $this->flash->error("خطا در هنگام ساخت کاربر جدید");
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
        $workers = Worker::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $workers,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد کارمند', 'کد کاربری', 'نام', 'نام خانوادگی', 'بخش عملیاتی', 'تاریخ', 'شماره تماس', 'موبایل', 'وضعیت'
                ))->
                setFields(array(
                    'id', 'userid', 'firstname', 'lastname', 'workersectionid', 'getDate()', 'phone', 'mobile', 'status'
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
        $item = Worker::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'worker',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Worker::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('در هنگام حذف کارمند مشکلی رخ داد');
            } else {
                $this->flash->success('کارمند با موفقیت حذف گردید');
                return $this->dispatcher->forward(array(
                            'controller' => 'worker',
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




        // create form
        $fr = new WorkerForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $worker = Worker::findFirst($id);

                $worker->firstname = $this->request->getPost('firstname', 'string');
                $worker->lastname = $this->request->getPost('lastname', 'string');
                $worker->fathername = $this->request->getPost('fathername', 'string');
                $worker->identitynumber = $this->request->getPost('identitynumber', 'string');
                $worker->birthday = $this->request->getPost('birthday', 'string');
                $worker->workersectionid = $this->request->getPost('workersectionid', 'string');
                $worker->address = $this->request->getPost('address', 'string');
                $worker->phone = $this->request->getPost('phone', 'string');
                $worker->mobile = $this->request->getPost('mobile', 'string');
                $worker->status = $this->request->getPost('status', 'string');


                // check if user has choosed a profile image
                if ($this->request->hasFiles() && $this->request->getUploadedFiles()[0]->getSize() > 0) {
                    // valid request, load the files
                    $file = $this->request->getUploadedFiles()[0];
                    $image = FileManager::HandleImageUpload($this->errors, $file, $outputname, $realtiveloaction);
                    if ($image) {
                        // unable to upload file
                        $image->link = $this->url->publicurl . "" . $realtiveloaction;
                        $image->save();

                        // change user image
                        $user = Worker::findFirst($id)->getUser();
                        $user->imagelink = $image->link;
                        if ($user->save()) {
                            $worker->showSuccessMessages($this, 'تصویر پروفایل با موفیت ثبت گردید');
                        }
                    } else {
                        $this->flash->error("خطا در هنگام ارسال فایل");
                    }
                }


                if (!$worker->save()) {
                    $worker->showErrorMessages($this);
                } else {
                    $worker->showSuccessMessages($this, 'کارمند با موفقیت ذخیره گردید');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $workerItem = Worker::findFirst($id);
            $fr->get('userid')->setDefault($workerItem->userid);
            $fr->get('firstname')->setDefault($workerItem->firstname);
            $fr->get('lastname')->setDefault($workerItem->lastname);
            $fr->get('fathername')->setDefault($workerItem->fathername);
            $fr->get('identitynumber')->setDefault($workerItem->identitynumber);
            $fr->get('birthday')->setDefault($workerItem->birthday);
            $fr->get('workersectionid')->setDefault($workerItem->workersectionid);
            $fr->get('address')->setDefault($workerItem->address);
            $fr->get('phone')->setDefault($workerItem->phone);
            $fr->get('mobile')->setDefault($workerItem->mobile);
            $fr->get('status')->setDefault($workerItem->status);
        }

        $workerItem = Worker::findFirst($id);
        $this->view->worker = $workerItem;
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Worker::findFirst($id);
        $this->view->item = $item;

        $form = new WorkerForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('firstname')->setDefault($item->firstname);
        $form->get('lastname')->setDefault($item->lastname);
        $form->get('fathername')->setDefault($item->fathername);
        $form->get('identitynumber')->setDefault($item->identitynumber);
        $form->get('birthday')->setDefault($item->birthday);
        $form->get('workersectionid')->setDefault($item->workersectionid);
        $form->get('date')->setDefault($item->date);
        $form->get('address')->setDefault($item->address);
        $form->get('phone')->setDefault($item->phone);
        $form->get('mobile')->setDefault($item->mobile);
        $form->get('status')->setDefault($item->status);
        $this->view->form = $form;
    }

}
