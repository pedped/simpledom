<?php

namespace Simpledom\Admin\Controllers;

use AppDownload;
use AppDownloadForm;
use AtaPaginator;
use Simpledom\Admin\BaseControllers\ControllerBase;

class AppDownloadController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('AppDownload');
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

        $fr = new AppDownloadForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $appdownload = new \AppDownload();

                $appdownload->ip = $this->request->getPost('ip', 'string');
                $appdownload->userid = $this->request->getPost('userid', 'string');
                $appdownload->link = $this->request->getPost('link', 'string');
                $appdownload->date = $this->request->getPost('date', 'string');
                $appdownload->appversion = $this->request->getPost('appversion', 'string');
                $appdownload->agent = $this->request->getPost('agent', 'string');
                if (!$appdownload->create()) {
                    $appdownload->showErrorMessages($this);
                } else {
                    $appdownload->showSuccessMessages($this, 'New AppDownload added Successfully');

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
        $appdownloads = AppDownload::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $appdownloads,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'IP', 'User ID', 'Link', 'Date', 'App Version', 'Agent'
                ))->
                setFields(array(
                    'id', 'ip', 'userid', 'link', 'getDate()', 'appversion', 'agent'
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
        $item = AppDownload::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'appdownload',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = AppDownload::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this AppDownload item');
            } else {
                $this->flash->success('AppDownload item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'appdownload',
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
        $this->setTitle('Edit AppDownload');

        $appdownloadItem = AppDownload::findFirst($id);

        // create form
        $fr = new AppDownloadForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $appdownload = AppDownload::findFirst($id);
                $appdownload->ip = $this->request->getPost('ip', 'string');

                $appdownload->userid = $this->request->getPost('userid', 'string');

                $appdownload->link = $this->request->getPost('link', 'string');

                $appdownload->date = $this->request->getPost('date', 'string');

                $appdownload->appversion = $this->request->getPost('appversion', 'string');

                $appdownload->agent = $this->request->getPost('agent', 'string');
                if (!$appdownload->save()) {
                    $appdownload->showErrorMessages($this);
                } else {
                    $appdownload->showSuccessMessages($this, 'AppDownload Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('ip')->setDefault($appdownloadItem->ip);
            $fr->get('userid')->setDefault($appdownloadItem->userid);
            $fr->get('link')->setDefault($appdownloadItem->link);
            $fr->get('date')->setDefault($appdownloadItem->date);
            $fr->get('appversion')->setDefault($appdownloadItem->appversion);
            $fr->get('agent')->setDefault($appdownloadItem->agent);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = AppDownload::findFirst($id);
        $this->view->item = $item;

        $form = new AppDownloadForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('ip')->setDefault($item->ip);
        $form->get('userid')->setDefault($item->userid);
        $form->get('link')->setDefault($item->link);
        $form->get('date')->setDefault($item->date);
        $form->get('appversion')->setDefault($item->appversion);
        $form->get('agent')->setDefault($item->agent);
        $this->view->form = $form;
    }

}
