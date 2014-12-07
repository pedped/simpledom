<?php

namespace Simpledom\Frontend\Controllers;

use AtaPaginator;
use City;
use CreateOrganForm;
use Organ;
use OrganDashboardForm;
use OrganForm;
use OrganSentMessage;
use OrganSentMessageForm;
use Post;
use PostForm;
use SendPermission;
use SendPermissionForm;
use Simpledom\Frontend\BaseControllers\ControllerBase;
use State;
use UserPost;
use UserPostForm;

class OrganController extends ControllerBase {

    private $organID;

    /**
     *
     * @var Organ 
     */
    private $organ;

    public function initialize() {
        parent::initialize();

        // check for action name
        if ($this->dispatcher->getActionName() == "add") {
            // user want to add new oragn
        } else {
            // get organ id
            $this->organID = $this->dispatcher->getParam("organid");
            $this->organ = Organ::findFirst(array("id = :id:", "bind" => array("id" => $this->organID)));
            $this->view->currentOrgan = $this->organ;
        }
        
        $this->view->organId = $this->organID;;
    }

    public function dashboardAction() {


        $fr = new OrganDashboardForm();
        $this->handleFormScripts($fr);

        $userPost = new UserPost();
        $this->view->totalUsers = $userPost->rawQuery("SELECT COUNT(*) as total FROM userpost JOIN post ON userpost.postid = post.id WHERE post.organid = ?", array($this->organID))->getFirst()->total;
        $this->view->totalMessages = OrganSentMessage::count(array("organid = :organid:", "bind" => array("organid" => $this->organID)));
        $this->view->thisMonthSentMessage = OrganSentMessage::count(
                        array(
                            "organid = :organid: AND date > :date:",
                            "bind" => array(
                                "organid" => $this->organID,
                                "date" => time() - (3600 * 24 * 30)
                            )
        ));
        $this->view->currentCredit = $this->organ->getSMSCredit();
        $this->listSentMessageAction(1, 20);
        $this->view->form = $fr;
    }

    public function postsAction($page = 1) {
        $this->listPostAction($page);
    }

    public function usersAction($page = 1) {
        $this->listUserPostAction($page);
    }

    public function sentmessageAction($page = 1) {
        $this->listSentMessageAction($page);
    }

    public function permissionsAction($page = 1) {
        $this->listSendPermissionAction($page);
    }

    public function creditAction() {

        // find organ credit
        $smsCredit = $this->organ->getSMSCredit();

        // show in view
        $this->view->smsCredit = $smsCredit;
    }

    public function settingsAction() {
        $this->editAction();
    }

    public function addSentMessageAction() {

        $fr = new OrganSentMessageForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $organsentmessage = new OrganSentMessage();

                $organsentmessage->organid = $this->request->getPost('organid', 'string');
                $organsentmessage->message = $this->request->getPost('message', 'string');
                $organsentmessage->date = $this->request->getPost('date', 'string');
                $organsentmessage->sendernumber = $this->request->getPost('sendernumber', 'string');
                $organsentmessage->fromnumber = $this->request->getPost('fromnumber', 'string');
                $organsentmessage->tonumber = $this->request->getPost('tonumber', 'string');
                $organsentmessage->cost = $this->request->getPost('cost', 'string');
                if (!$organsentmessage->create()) {
                    $organsentmessage->showErrorMessages($this);
                } else {
                    $organsentmessage->showSuccessMessages($this, 'New OrganSentMessage added Successfully');

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

    public function listSentMessageAction($page = 1, $limit = 20) {

        // load the users
        $organsentmessages = OrganSentMessage::find(
                        array(
                            "organid = :organid:",
                            "bind" => array("organid" => $this->organID),
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $organsentmessages,
            'limit' => 20,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'شناسه', 'پیام', 'تاریخ', 'شماره ارسال کننده', 'از شماره', 'به شماره', 'هزینه'
                ))->
                setFields(array(
                    'id', 'message', 'getDate()', 'sendernumber', 'fromnumber', 'tonumber', 'cost'
                ))->setListPath(
                'list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteSentMessageAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = OrganSentMessage::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'organsentmessage',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = OrganSentMessage::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this OrganSentMessage item');
            } else {
                $this->flash->success('OrganSentMessage item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'organsentmessage',
                            'action' => 'list'
                ));
            }
        }
    }

    public function editSentMessageAction($id) {


        if (!$this->ValidateAccess($id)) {
            // user do not have permission to edut this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // set title
        $this->setTitle('Edit OrganSentMessage');

        $organsentmessageItem = OrganSentMessage::findFirst($id);

        // create form
        $fr = new OrganSentMessageForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $organsentmessage = OrganSentMessage::findFirst($id);
                $organsentmessage->organid = $this->request->getPost('organid', 'string');

                $organsentmessage->message = $this->request->getPost('message', 'string');

                $organsentmessage->date = $this->request->getPost('date', 'string');

                $organsentmessage->sendernumber = $this->request->getPost('sendernumber', 'string');

                $organsentmessage->fromnumber = $this->request->getPost('fromnumber', 'string');

                $organsentmessage->tonumber = $this->request->getPost('tonumber', 'string');

                $organsentmessage->cost = $this->request->getPost('cost', 'string');
                if (!$organsentmessage->save()) {
                    $organsentmessage->showErrorMessages($this);
                } else {
                    $organsentmessage->showSuccessMessages($this, 'OrganSentMessage Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('organid')->setDefault($organsentmessageItem->organid);
            $fr->get('message')->setDefault($organsentmessageItem->message);
            $fr->get('date')->setDefault($organsentmessageItem->date);
            $fr->get('sendernumber')->setDefault($organsentmessageItem->sendernumber);
            $fr->get('fromnumber')->setDefault($organsentmessageItem->fromnumber);
            $fr->get('tonumber')->setDefault($organsentmessageItem->tonumber);
            $fr->get('cost')->setDefault($organsentmessageItem->cost);
        }

        $this->view->form = $fr;
    }

    public function viewSentMessageAction($id) {

        $item = OrganSentMessage::findFirst($id);
        $this->view->item = $item;

        $form = new OrganSentMessageForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('organid')->setDefault($item->organid);
        $form->get('message')->setDefault($item->message);
        $form->get('date')->setDefault($item->date);
        $form->get('sendernumber')->setDefault($item->sendernumber);
        $form->get('fromnumber')->setDefault($item->fromnumber);
        $form->get('tonumber')->setDefault($item->tonumber);
        $form->get('cost')->setDefault($item->cost);
        $this->view->form = $form;
    }

    /* Start Send Permission    * ===================================================================================================
     * 
      ==================================================================================================== */

    public function addSendPermissionAction() {

        $fr = new SendPermissionForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $sendpermission = new SendPermission();

                $sendpermission->userpost1 = $this->request->getPost('userpost1', 'string');
                $sendpermission->userpost2 = $this->request->getPost('userpost2', 'string');
                $sendpermission->cansend = $this->request->getPost('cansend', 'string');
                if (!$sendpermission->create()) {
                    $sendpermission->showErrorMessages($this);
                } else {
                    $sendpermission->showSuccessMessages($this, 'New SendPermission added Successfully');

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

    public function listSendPermissionAction($page = 1) {

        // load the users
        $sendpermissions = SendPermission::find(
                        array(
                            'order' => 'userpost1 DESC , id DESC '
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $sendpermissions,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'شناسه', 'سمت ارسال کننده', 'سمت گیرنده', 'قابلیت ارسال'
                ))->
                setFields(array(
                    'id', 'getUserPostOneName()', 'getUserPostTwoName()', 'canSendTitle()'
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

    public function deleteSendPermissionAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = SendPermission::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'sendpermission',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = SendPermission::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this SendPermission item');
            } else {
                $this->flash->success('SendPermission item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'sendpermission',
                            'action' => 'list'
                ));
            }
        }
    }

    public function editSendPermissionAction($id) {


        if (!$this->ValidateAccess($id)) {
            // user do not have permission to edut this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // set title
        $this->setTitle('Edit SendPermission');

        $sendpermissionItem = SendPermission::findFirst($id);

        // create form
        $fr = new SendPermissionForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $sendpermission = SendPermission::findFirst($id);
                $sendpermission->userpost1 = $this->request->getPost('userpost1', 'string');

                $sendpermission->userpost2 = $this->request->getPost('userpost2', 'string');

                $sendpermission->cansend = $this->request->getPost('cansend', 'string');
                if (!$sendpermission->save()) {
                    $sendpermission->showErrorMessages($this);
                } else {
                    $sendpermission->showSuccessMessages($this, 'SendPermission Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('userpost1')->setDefault($sendpermissionItem->userpost1);
            $fr->get('userpost2')->setDefault($sendpermissionItem->userpost2);
            $fr->get('cansend')->setDefault($sendpermissionItem->cansend);
        }

        $this->view->form = $fr;
    }

    public function viewSendPermissionAction($id) {

        $item = SendPermission::findFirst($id);
        $this->view->item = $item;

        $form = new SendPermissionForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userpost1')->setDefault($item->userpost1);
        $form->get('userpost2')->setDefault($item->userpost2);
        $form->get('cansend')->setDefault($item->cansend);
        $this->view->form = $form;
    }

    /* End Send Permission * ===================================================================================================
     * 
      ==================================================================================================== */


    /* Start User Posts    * ===================================================================================================
     * 
      ==================================================================================================== */

    public function addUserPostAction() {

        $fr = new UserPostForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $userpost = new UserPost();

                $userpost->userid = $this->request->getPost('userid', 'string');
                $userpost->postid = $this->request->getPost('postid', 'string');
                $userpost->code = $this->request->getPost('code', 'string');
                $userpost->phonenumber = $this->request->getPost('phonenumber', 'string');
                if (!$userpost->create()) {
                    $userpost->showErrorMessages($this);
                } else {
                    $userpost->showSuccessMessages($this, 'New UserPost added Successfully');

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

    public function listUserPostAction($page = 1) {

        // load the users
        $userposts = UserPost::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $userposts,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'شناسه', 'نام', 'سمت', 'شماره تماس', 'کد اختصاصی'
                ))->
                setFields(array(
                    'id', 'getUserName()', 'getPostTitle()', 'phonenumber', 'code'
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

    public function deleteUserPostAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = UserPost::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'userpost',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = UserPost::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this UserPost item');
            } else {
                $this->flash->success('UserPost item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'userpost',
                            'action' => 'list'
                ));
            }
        }
    }

    public function editUserPostAction($id) {


        if (!$this->ValidateAccess($id)) {
            // user do not have permission to edut this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // set title
        $this->setTitle('Edit UserPost');

        $userpostItem = UserPost::findFirst($id);

        // create form
        $fr = new UserPostForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $userpost = UserPost::findFirst($id);
                $userpost->userid = $this->request->getPost('userid', 'string');
                $userpost->phonenumber = $this->request->getPost('phonenumber', 'string');
                $userpost->postid = $this->request->getPost('postid', 'string');
                $userpost->code = $this->request->getPost('code', 'string');
                if (!$userpost->save()) {
                    $userpost->showErrorMessages($this);
                } else {
                    $userpost->showSuccessMessages($this, 'UserPost Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('phonenumber')->setDefault($userpostItem->phonenumber);
            $fr->get('userid')->setDefault($userpostItem->userid);
            $fr->get('postid')->setDefault($userpostItem->postid);
            $fr->get('code')->setDefault($userpostItem->code);
        }

        $this->view->form = $fr;
    }

    public function viewUserPostAction($id) {

        $item = UserPost::findFirst($id);
        $this->view->item = $item;

        $form = new UserPostForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('phonenumber')->setDefault($item->phonenumber);
        $form->get('userid')->setDefault($item->userid);
        $form->get('postid')->setDefault($item->postid);
        $form->get('code')->setDefault($item->code);
        $this->view->form = $form;
    }

    /* End User Posts    * ===================================================================================================
     * 
      ==================================================================================================== */







    /* Start Posts    * ===================================================================================================
     * 
      ==================================================================================================== */

    public function addPostAction() {

        $fr = new PostForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $post = new Post();

                $post->organid = $this->request->getPost('organid', 'string');
                $post->name = $this->request->getPost('name', 'string');
                $post->key = $this->request->getPost('key', 'string');
                $post->smskey = $this->request->getPost('smskey', 'string');
                if (!$post->create()) {
                    $post->showErrorMessages($this);
                } else {
                    $post->showSuccessMessages($this, 'New Post added Successfully');

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

    public function listPostAction($page = 1) {

        // load the users
        $posts = Post::find(
                        array(
                            "organid = :organid:",
                            "bind" => array(
                                "organid" => $this->organID
                            ),
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $posts,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'نام', 'کلید', 'کلید پیامک'
                ))->
                setFields(array(
                    'id', 'name', 'key', 'smskey'
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

    public function deletePostAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = Post::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'post',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Post::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Post item');
            } else {
                $this->flash->success('Post item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'post',
                            'action' => 'list'
                ));
            }
        }
    }

    public function editPostAction($id) {


        if (!$this->ValidateAccess($id)) {
            // user do not have permission to edut this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // set title
        $this->setTitle('Edit Post');

        $postItem = Post::findFirst($id);

        // create form
        $fr = new PostForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $post = Post::findFirst($id);
                $post->organid = $this->request->getPost('organid', 'string');

                $post->name = $this->request->getPost('name', 'string');

                $post->key = $this->request->getPost('key', 'string');

                $post->smskey = $this->request->getPost('smskey', 'string');
                if (!$post->save()) {
                    $post->showErrorMessages($this);
                } else {
                    $post->showSuccessMessages($this, 'Post Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('organid')->setDefault($postItem->organid);
            $fr->get('name')->setDefault($postItem->name);
            $fr->get('key')->setDefault($postItem->key);
            $fr->get('smskey')->setDefault($postItem->smskey);
        }

        $this->view->form = $fr;
    }

    public function viewPostAction($id) {

        $item = Post::findFirst($id);
        $this->view->item = $item;

        $form = new PostForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('organid')->setDefault($item->organid);
        $form->get('name')->setDefault($item->name);
        $form->get('key')->setDefault($item->key);
        $form->get('smskey')->setDefault($item->smskey);
        $this->view->form = $form;
    }

    /* End Posts      * ===================================================================================================
     * 
      ==================================================================================================== */

    /**
     * this function will validate request access
     * @param type $id
     * @return boolean
     */
    protected function ValidateAccess($id) {
        return true;
    }

    public function addAction() {

        $this->setPageTitle("اضافه کردن ارگان");

        $fr = new CreateOrganForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $organ = new \Organ();

                $organ->name = $this->request->getPost('name', 'string');
                $organ->username = $this->request->getPost('username', 'string');
                $organ->password = $this->request->getPost('password', 'string');
                $organ->email = $this->request->getPost('email', 'email');
                // todo  in ghesmat alaki 1 gozashtam hatman barresi shavad.
                $organ->byuserid = "1";
                $organ->smscredit = "12";
                $organ->status = "1";
                
                $organ->address = $this->request->getPost('address', 'string');
                $organ->stateid = $this->request->getPost('stateid', 'string');
                $organ->cityid = $this->request->getPost('cityid', 'string');
                $organ->description = $this->request->getPost('description', 'string');
                $organ->phonenumber = $this->request->getPost('phonenumber', 'string');
                $organ->interfaceurl = $this->request->getPost('interfaceurl', 'string');
                $organ->useinterface = $this->request->getPost('useinterface', 'string');
                $organ->disablemessage = $this->request->getPost('disablemessage', 'string');
                $organ->date = $this->request->getPost('date', 'string');
                $organ->smsnumberid = $this->request->getPost('smsnumberid', 'string');
                if (!$organ->create()) {
                    $organ->showErrorMessages($this);
                } else {
                    $organ->showSuccessMessages($this, 'سازمان با موفقیت به سیستم اضافه شد.');

                    // clear the title and message so the user can add better info
                    $fr->clear();
                }
            } 
        }
        $this->view->form = $fr;
        $this->view->state = State::find();
        $this->view->city = City::find();
    }

    public function listAction($page = 1) {

        // load the users
        $organs = Organ::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $organs,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Name', 'By User', 'Address', 'State ID', 'City ID', 'Description', 'Phone Number', 'SMS Credit', 'Interface URL', 'Use Interface', 'Status', 'Disable Message', 'Date'
                ))->
                setFields(array(
                    'id', 'name', 'byuserid', 'address', 'stateid', 'cityid', 'description', 'phonenumber', 'smscredit', 'interfaceurl', 'useinterface', 'status', 'disablemessage', 'getDate()'
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
        $item = Organ::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'organ',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Organ::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Organ item');
            } else {
                $this->flash->success('Organ item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'organ',
                            'action' => 'list'
                ));
            }
        }
    }

    public function editAction() {


        // set title
        $this->setPageTitle('ویرایش ارگان');

        $organ = Organ::findFirst(array("id = :id:", "bind" => array("id" => $this->organID)));

        // create form
        $fr = new \CreateOrganForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $organ = Organ::findFirst($this->organID);
                $organ->name = $this->request->getPost('name', 'string');
                $organ->address = $this->request->getPost('address', 'string');
                $organ->stateid = $this->request->getPost('stateid', 'string');
                $organ->cityid = $this->request->getPost('cityid', 'string');
                $organ->description = $this->request->getPost('description', 'string');
                $organ->interfaceurl = $this->request->getPost('interfaceurl', 'string');
                $organ->useinterface = $this->request->hasPost('useinterface') ? $this->request->getPost('useinterface') : 0;
                
                
                if (!$organ->save()) {
                    $organ->showErrorMessages($this);
                } else {
                    $organ->showSuccessMessages($this, 'با موفقیت ذخیره شد.');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }
        // set default values
        $fr->get('name')->setDefault($organ->name);
        $fr->get('address')->setDefault($organ->address);
        $fr->get('stateid')->setDefault($organ->stateid);
        $fr->get('cityid')->setDefault($organ->cityid);
        $fr->get('description')->setDefault($organ->description);
        $fr->get('phonenumber')->setDefault($organ->phonenumber);
        $fr->get('interfaceurl')->setDefault($organ->interfaceurl);
        $fr->get('useinterface')->setDefault($organ->useinterface);
        
        $this->view->form = $fr;
        $this->view->state = State::find();
        $this->view->city = City::find();
    }

    public function viewAction($id) {

        $item = Organ::findFirst($id);
        $this->view->item = $item;

        $form = new OrganForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('name')->setDefault($item->name);
        $form->get('byuserid')->setDefault($item->byuserid);
        $form->get('address')->setDefault($item->address);
        $form->get('stateid')->setDefault($item->stateid);
        $form->get('cityid')->setDefault($item->cityid);
        $form->get('description')->setDefault($item->description);
        $form->get('phonenumber')->setDefault($item->phonenumber);
        $form->get('smscredit')->setDefault($item->smscredit);
        $form->get('interfaceurl')->setDefault($item->interfaceurl);
        $form->get('useinterface')->setDefault($item->useinterface);
        $form->get('smsnumberid')->setDefault($item->smsnumberid);
        $form->get('status')->setDefault($item->status);
        $form->get('disablemessage')->setDefault($item->disablemessage);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
