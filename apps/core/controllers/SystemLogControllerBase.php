<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use Simpledom\Core\SystemLogForm;
use BaseSystemLog;

class SystemLogControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('SystemLog');
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

        $fr = new SystemLogForm();
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $systemlog = new \BaseSystemLog();

                $systemlog->title = $this->request->getPost('title', 'string');
                $systemlog->ip = $this->request->getPost('ip', 'string');
                $systemlog->message = $this->request->getPost('message', 'string');
                $systemlog->date = $this->request->getPost('date', 'string');
                if (!$systemlog->create()) {
                    $systemlog->showErrorMessages($this);
                } else {
                    $systemlog->showSuccessMessages($this, 'New SystemLog added Successfully');

                    // clear the title and message so the user can add better info
                    $fr->clear();
                }
            } else {
                // invalid
            }
        }
        $this->view->form = $fr;
    }

    public function listAction($page = 1) {

        // load the users
        $systemlogs = BaseSystemLog::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $systemlogs,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', "Type", 'Title', 'Message', 'Date', 'IP'
                ))->
                setFields(array(
                    'id', 'getTypeIcon()', 'title', 'message', 'getDate()', 'ip'
                ))->
                setEditUrl(
                        'view'
                )->setListPath(
                'list');

        $this->view->list = $paginator->getPaginate();
    }

    public function viewAction($id) {

        $item = BaseSystemLog::findFirst($id);
        $this->view->item = $item;

        $form = new SystemLogForm();
        $form->get('id')->setDefault($item->id);
        $form->get('title')->setDefault($item->title);
        $form->get('ip')->setDefault($item->ip);
        $form->get('message')->setDefault($item->message);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
