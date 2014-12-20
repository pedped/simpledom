<?php
namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use MobileNotification;
use Simpledom\Core\MobileNotificationForm;

class MobilenotificationControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('MobileNotification');
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

        $fr = new MobileNotificationForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $mobilenotification = new \MobileNotification();

                $mobilenotification->title = $this->request->getPost('title', 'string');
                $mobilenotification->message = $this->request->getPost('message', 'string');
                $mobilenotification->link = $this->request->getPost('link', 'string');
                $mobilenotification->linktext = $this->request->getPost('linktext', 'string');
                $mobilenotification->date = $this->request->getPost('date', 'string');
                $mobilenotification->releasedate = $this->request->getPost('releasedate', 'string');
                $mobilenotification->enable = $this->request->getPost('enable', 'string');
                $mobilenotification->byip = $this->request->getPost('byip', 'string');
                if (!$mobilenotification->create()) {
                    $mobilenotification->showErrorMessages($this);
                } else {
                    $mobilenotification->showSuccessMessages($this, 'New MobileNotification added Successfully');

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
        $mobilenotifications = MobileNotification::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $mobilenotifications,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Title','Message','Link','Link Text','Date','Release Date','Enable','By IP' , 'View Count'
                ))->
                setFields(array(
                    'id','title','message','link','linktext','getDate()','releasedate','enable','byip' , 'viewcount'
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
        $item = MobileNotification::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'mobilenotification',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = MobileNotification::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this MobileNotification item');
            } else {
                $this->flash->success('MobileNotification item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'mobilenotification',
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
        $this->setTitle('Edit MobileNotification');

        $mobilenotificationItem = MobileNotification::findFirst($id);

        // create form
        $fr = new MobileNotificationForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $mobilenotification = MobileNotification::findFirst($id);
                                $mobilenotification->title = $this->request->getPost('title', 'string');

                                $mobilenotification->message = $this->request->getPost('message', 'string');

                                $mobilenotification->link = $this->request->getPost('link', 'string');

                                $mobilenotification->linktext = $this->request->getPost('linktext', 'string');

                                $mobilenotification->date = $this->request->getPost('date', 'string');

                                $mobilenotification->releasedate = $this->request->getPost('releasedate', 'string');

                                $mobilenotification->enable = $this->request->getPost('enable', 'string');

                                $mobilenotification->byip = $this->request->getPost('byip', 'string');
                if (!$mobilenotification->save()) {
                    $mobilenotification->showErrorMessages($this);
                } else {
                    $mobilenotification->showSuccessMessages($this, 'MobileNotification Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('title')->setDefault($mobilenotificationItem->title);
                        $fr->get('message')->setDefault($mobilenotificationItem->message);
                        $fr->get('link')->setDefault($mobilenotificationItem->link);
                        $fr->get('linktext')->setDefault($mobilenotificationItem->linktext);
                        $fr->get('date')->setDefault($mobilenotificationItem->date);
                        $fr->get('releasedate')->setDefault($mobilenotificationItem->releasedate);
                        $fr->get('enable')->setDefault($mobilenotificationItem->enable);
                        $fr->get('byip')->setDefault($mobilenotificationItem->byip); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = MobileNotification::findFirst($id);
        $this->view->item = $item;

        $form = new MobileNotificationForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('title')->setDefault($item->title);$form->get('message')->setDefault($item->message);$form->get('link')->setDefault($item->link);$form->get('linktext')->setDefault($item->linktext);$form->get('date')->setDefault($item->date);$form->get('releasedate')->setDefault($item->releasedate);$form->get('enable')->setDefault($item->enable);$form->get('byip')->setDefault($item->byip);$this->view->form = $form;
        
    }

}
