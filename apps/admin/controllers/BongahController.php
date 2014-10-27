<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use Bongah;
use BongahForm;

class BongahController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Bongah');
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

        $fr = new BongahForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongah = new \Bongah();

                $bongah->title = $this->request->getPost('title', 'string');
                $bongah->peygiri = $this->request->getPost('peygiri', 'string');
                $bongah->fname = $this->request->getPost('fname', 'string');
                $bongah->lname = $this->request->getPost('lname', 'string');
                $bongah->address = $this->request->getPost('address', 'string');
                $bongah->cityid = $this->request->getPost('cityid', 'string');
                $bongah->latitude = $this->request->getPost('latitude', 'string');
                $bongah->longitude = $this->request->getPost('longitude', 'string');
                $bongah->locationscansupport = $this->request->getPost('locationscansupport', 'string');
                $bongah->mobile = $this->request->getPost('mobile', 'string');
                $bongah->phone = $this->request->getPost('phone', 'string');
                $bongah->enable = $this->request->getPost('enable', 'string');
                $bongah->featured = $this->request->getPost('featured', 'string');
                $bongah->date = $this->request->getPost('date', 'string');
                if (!$bongah->create()) {
                    $bongah->showErrorMessages($this);
                } else {
                    $bongah->showSuccessMessages($this, 'New Bongah added Successfully');

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
        $bongahs = Bongah::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $bongahs,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Title','Shomare Peygiri','First Name','Last Name','Address','City','Latitude','Longitude','Locations Can Support','Mobile','Phone','Enable','Featured','Date'
                ))->
                setFields(array(
                    'id','title','peygiri','fname','lname','address','cityid','latitude','longitude','locationscansupport','mobile','phone','enable','featured','getDate()'
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
        $item = Bongah::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'bongah',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Bongah::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Bongah item');
            } else {
                $this->flash->success('Bongah item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'bongah',
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
        $this->setTitle('Edit Bongah');

        $bongahItem = Bongah::findFirst($id);

        // create form
        $fr = new BongahForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongah = Bongah::findFirst($id);
                                $bongah->title = $this->request->getPost('title', 'string');

                                $bongah->peygiri = $this->request->getPost('peygiri', 'string');

                                $bongah->fname = $this->request->getPost('fname', 'string');

                                $bongah->lname = $this->request->getPost('lname', 'string');

                                $bongah->address = $this->request->getPost('address', 'string');

                                $bongah->cityid = $this->request->getPost('cityid', 'string');

                                $bongah->latitude = $this->request->getPost('latitude', 'string');

                                $bongah->longitude = $this->request->getPost('longitude', 'string');

                                $bongah->locationscansupport = $this->request->getPost('locationscansupport', 'string');

                                $bongah->mobile = $this->request->getPost('mobile', 'string');

                                $bongah->phone = $this->request->getPost('phone', 'string');

                                $bongah->enable = $this->request->getPost('enable', 'string');

                                $bongah->featured = $this->request->getPost('featured', 'string');

                                $bongah->date = $this->request->getPost('date', 'string');
                if (!$bongah->save()) {
                    $bongah->showErrorMessages($this);
                } else {
                    $bongah->showSuccessMessages($this, 'Bongah Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('title')->setDefault($bongahItem->title);
                        $fr->get('peygiri')->setDefault($bongahItem->peygiri);
                        $fr->get('fname')->setDefault($bongahItem->fname);
                        $fr->get('lname')->setDefault($bongahItem->lname);
                        $fr->get('address')->setDefault($bongahItem->address);
                        $fr->get('cityid')->setDefault($bongahItem->cityid);
                        $fr->get('latitude')->setDefault($bongahItem->latitude);
                        $fr->get('longitude')->setDefault($bongahItem->longitude);
                        $fr->get('locationscansupport')->setDefault($bongahItem->locationscansupport);
                        $fr->get('mobile')->setDefault($bongahItem->mobile);
                        $fr->get('phone')->setDefault($bongahItem->phone);
                        $fr->get('enable')->setDefault($bongahItem->enable);
                        $fr->get('featured')->setDefault($bongahItem->featured);
                        $fr->get('date')->setDefault($bongahItem->date); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Bongah::findFirst($id);
        $this->view->item = $item;

        $form = new BongahForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('title')->setDefault($item->title);$form->get('peygiri')->setDefault($item->peygiri);$form->get('fname')->setDefault($item->fname);$form->get('lname')->setDefault($item->lname);$form->get('address')->setDefault($item->address);$form->get('cityid')->setDefault($item->cityid);$form->get('latitude')->setDefault($item->latitude);$form->get('longitude')->setDefault($item->longitude);$form->get('locationscansupport')->setDefault($item->locationscansupport);$form->get('mobile')->setDefault($item->mobile);$form->get('phone')->setDefault($item->phone);$form->get('enable')->setDefault($item->enable);$form->get('featured')->setDefault($item->featured);$form->get('date')->setDefault($item->date);$this->view->form = $form;
        
    }

}
