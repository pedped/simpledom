<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use MelkInfo;
use MelkInfoForm;

class MelkInfoController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('MelkInfo');
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

        $fr = new MelkInfoForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melkinfo = new \MelkInfo();

                $melkinfo->melkid = $this->request->getPost('melkid', 'string');
                $melkinfo->address = $this->request->getPost('address', 'string');
                $melkinfo->latitude = $this->request->getPost('latitude', 'string');
                $melkinfo->longitude = $this->request->getPost('longitude', 'string');
                $melkinfo->facilities = $this->request->getPost('facilities', 'string');
                $melkinfo->total_view = $this->request->getPost('total_view', 'string');
                $melkinfo->search_meta = $this->request->getPost('search_meta', 'string');
                $melkinfo->private_phone = $this->request->getPost('private_phone', 'string');
                $melkinfo->private_mobile = $this->request->getPost('private_mobile', 'string');
                $melkinfo->private_address = $this->request->getPost('private_address', 'string');
                if (!$melkinfo->create()) {
                    $melkinfo->showErrorMessages($this);
                } else {
                    $melkinfo->showSuccessMessages($this, 'New MelkInfo added Successfully');

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
        $melkinfos = MelkInfo::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $melkinfos,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Melk ID','Address','Latitude','Longitude','Facilities','Total View','Search Meta Information','Private Phone','Private Mobile','Private Address'
                ))->
                setFields(array(
                    'id','melkid','address','latitude','longitude','facilities','total_view','search_meta','private_phone','private_mobile','private_address'
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
        $item = MelkInfo::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'melkinfo',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = MelkInfo::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this MelkInfo item');
            } else {
                $this->flash->success('MelkInfo item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'melkinfo',
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
        $this->setTitle('Edit MelkInfo');

        $melkinfoItem = MelkInfo::findFirst($id);

        // create form
        $fr = new MelkInfoForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melkinfo = MelkInfo::findFirst($id);
                                $melkinfo->melkid = $this->request->getPost('melkid', 'string');

                                $melkinfo->address = $this->request->getPost('address', 'string');

                                $melkinfo->latitude = $this->request->getPost('latitude', 'string');

                                $melkinfo->longitude = $this->request->getPost('longitude', 'string');

                                $melkinfo->facilities = $this->request->getPost('facilities', 'string');

                                $melkinfo->total_view = $this->request->getPost('total_view', 'string');

                                $melkinfo->search_meta = $this->request->getPost('search_meta', 'string');

                                $melkinfo->private_phone = $this->request->getPost('private_phone', 'string');

                                $melkinfo->private_mobile = $this->request->getPost('private_mobile', 'string');

                                $melkinfo->private_address = $this->request->getPost('private_address', 'string');
                if (!$melkinfo->save()) {
                    $melkinfo->showErrorMessages($this);
                } else {
                    $melkinfo->showSuccessMessages($this, 'MelkInfo Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('melkid')->setDefault($melkinfoItem->melkid);
                        $fr->get('address')->setDefault($melkinfoItem->address);
                        $fr->get('latitude')->setDefault($melkinfoItem->latitude);
                        $fr->get('longitude')->setDefault($melkinfoItem->longitude);
                        $fr->get('facilities')->setDefault($melkinfoItem->facilities);
                        $fr->get('total_view')->setDefault($melkinfoItem->total_view);
                        $fr->get('search_meta')->setDefault($melkinfoItem->search_meta);
                        $fr->get('private_phone')->setDefault($melkinfoItem->private_phone);
                        $fr->get('private_mobile')->setDefault($melkinfoItem->private_mobile);
                        $fr->get('private_address')->setDefault($melkinfoItem->private_address); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = MelkInfo::findFirst($id);
        $this->view->item = $item;

        $form = new MelkInfoForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('melkid')->setDefault($item->melkid);$form->get('address')->setDefault($item->address);$form->get('latitude')->setDefault($item->latitude);$form->get('longitude')->setDefault($item->longitude);$form->get('facilities')->setDefault($item->facilities);$form->get('total_view')->setDefault($item->total_view);$form->get('search_meta')->setDefault($item->search_meta);$form->get('private_phone')->setDefault($item->private_phone);$form->get('private_mobile')->setDefault($item->private_mobile);$form->get('private_address')->setDefault($item->private_address);$this->view->form = $form;
        
    }

}
