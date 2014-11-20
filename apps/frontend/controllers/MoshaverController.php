<?php

namespace Simpledom\Frontend\Controllers;

use Answer;
use AtaPaginator;
use City;
use CreateMoshaverForm;
use Moshaver;
use MoshaverForm;
use MoshaverSettingsForm;
use Question;
use SendMoshaverAnswerForm;
use Settings;
use Simpledom\Frontend\BaseControllers\ControllerBase;
use SMSManager;
use SmsNumber;

class MoshaverController extends ControllerBase {

    public function initialize() {
        parent::initialize();
    }

    /**
     * this function will validate request access
     * @param type $id
     * @return boolean
     */
    protected function ValidateAccess($id) {
        return true;
    }

    public function cityAction() {
        $this->view->cities = City::find("captial = 1");
    }

    public function questionAction($questionID) {

        // check if question exist
        $question = Question::findFirst(array("id = :id:", "bind" => array("id" => $questionID)));
        if (!$question) {
            // question not found
            $this->show404();
        }

        // check if question belongs to this moshaver
        if ($question->moshaverid != $this->getUser()->userid) {
            // it is not belong to him\her
            $this->show404();
        }

        // create form
        $form = new SendMoshaverAnswerForm();
        $this->handleFormScripts($form);

        if ($this->request->isPost()) {
            if (!$form->isValid($_POST)) {
                // invalid request
            } else {
                // valid
                $answer = new Answer();
                $answer->userid = $this->getUser()->userid;
                $answer->message = $this->request->getPost("answer");
                $answer->questionid = $questionID;
                $answer->delete = "0";
                if (!$answer->create()) {
                    $answer->showErrorMessages($this);
                } else {
                    // answer created successfully
                    $answer->showSuccessMessages($this, "جواب شما با موفقیت ارسال گردید");

                    // send sms message to the askwer
                    SMSManager::SendSMS($question->getUser()->getVerifiedPhone(), "کاربر گرامی، سوال شما توسط مشاور پاسخ داده شده است، جهت مشاهده پاسخ به وبسایت وارد شوید", SmsNumber::findFirst()->id);

                    // clear the form
                    $form->clear();
                }
            }
        }


        // get answers
        $this->view->answers = Answer::find(array("questionid = :questionid:", "order" => "id ASC", "bind" => array("questionid" => $questionID)));


        // show in view
        $this->view->form = $form;
        $this->view->question = $question;
    }

    public function settingsAction() {

        // set title
        $this->setPageTitle('ویرایش اطلاعات مشاور');

        $moshaverItem = Moshaver::findFirst($this->getMoshaverID());

        // create form
        $fr = new MoshaverSettingsForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $moshaver = Moshaver::findFirst($this->getMoshaverID());
                $moshaver->cityid = $this->request->getPost('cityid', 'string');
                $moshaver->address = $this->request->getPost('address', 'string');
                $moshaver->phone = $this->request->getPost('phone', 'string');
                $moshaver->moshavertypeid = $this->request->getPost('moshavertypeid', 'string');
                $moshaver->degreetypeid = $this->request->getPost('degreetypeid', 'string');
                $moshaver->info = $this->request->getPost('info', 'string');

                if (!$moshaver->save()) {
                    $moshaver->showErrorMessages($this);
                } else {
                    $moshaver->showSuccessMessages($this, 'اطلاعات شما با موفقیت ذخیره گردید');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('cityid')->setDefault($moshaverItem->cityid);
            $fr->get('address')->setDefault($moshaverItem->address);
            $fr->get('phone')->setDefault($moshaverItem->phone);
            $fr->get('moshavertypeid')->setDefault($moshaverItem->moshavertypeid);
            $fr->get('degreetypeid')->setDefault($moshaverItem->degreetypeid);
            $fr->get('info')->setDefault($moshaverItem->info);
        }

        $this->view->form = $fr;
    }

    public function questionsAction($numberPage = 1) {

        // load the users
        $questions = Question::find(
                        array(
                            "moshaverid = :moshaverid:",
                            "bind" => array("moshaverid" => $this->getMoshaverID()),
                            "order" => "id DESC"
                        )
        );

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $questions,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'نام', 'سوال', 'شهر', 'تاریخ', 'وضعیت پاسخ', 'جواب'
                ))->
                setFields(array(
                    'id', 'getUserName()', 'question', 'getCityName()', 'getDate()', 'getAnswerState()', 'getAnswerButton()'
                ))->setListPath(
                'moshaver/index');

        $this->view->list = $paginator->getPaginate();
    }

    public function indexAction($numberPage = 1) {

        // load the users
        $q = new Question();
        $questions = $q->rawQuery("SELECT q.* , ( SELECT count(*) from answer ac WHERE ac.questionid = q.id ) as answerCount FROM question q LEFT JOIN answer a ON q.id = a.questionid WHERE q.moshaverid = ? AND ( 0 = ( SELECT count(*) from answer ac WHERE ac.questionid = q.id ) OR ? != (SELECT au.userid FROM answer au WHERE au.questionid = q.id ORDER BY au.id DESC LIMIT 1 ) ) ORDER BY q.id DESC LIMIT 10", array(
            $this->getMoshaverID(), $this->getUser()->userid
        ));



        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $questions,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'نام', 'سوال', 'شهر', 'تاریخ', 'وضعیت پاسخ', 'جواب'
                ))->
                setFields(array(
                    'id', 'getUserName()', 'question', 'getCityName()', 'getDate()', 'getAnswerState()', 'getAnswerButton()'
                ))->setListPath(
                'moshaver/index');

        $this->view->list = $paginator->getPaginate();
    }

    public function addAction() {

        // check if user is not logged in, request usre to login
        if (!isset($this->user)) {
            // user not logged in

            $this->flash->success("برای عضویت به عنوان مشاور، شما میبایست ابتدا در سایت ثبت نام نمایید");

            $this->dispatcher->forward(array(
                "controller" => "user",
                "action" => "register",
                "params" => array()
            ));

            // return
            return;
        }

        $fr = new CreateMoshaverForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $moshaver = new Moshaver();

                $moshaver->userid = $this->user->userid;
                $moshaver->cityid = $this->request->getPost('cityid', 'string');
                $moshaver->address = $this->request->getPost('address', 'string');
                $moshaver->phone = $this->user->getVerifiedPhone();
                $moshaver->moshavertypeid = $this->request->getPost('moshavertypeid', 'string');
                $moshaver->degreetypeid = $this->request->getPost('degreetypeid', 'string');
                $moshaver->info = $this->request->getPost('info', 'string');

                if (!$moshaver->create()) {
                    $moshaver->showErrorMessages($this);
                } else {

                    // create message
                    $message = "حساب شما با موفقیت ایجاد گردید، مدیر سایت برای تایید با شما تماس خواهد گرفت، لطفا منتظر تماس از طرف مدیر سایت بمانید";
                    $message .= "با تشکر " . Settings::Get()->websitename;
                    $message .= "\n" . $this->url->getBaseUri();

                    // show success message
                    $this->flash->success($message);

                    // send message
                    SMSManager::SendSMS($this->user->getVerifiedPhone(), $message, SmsNumber::findFirst()->id);

                    // forward to home page
                    $this->dispatcher->forward(array(
                        "controller" => "index",
                        "action" => "index",
                        "params" => array()
                    ));

                    // clear the title and message so the user can add better info
                    $fr->clear();
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }
        $fr->get("phone")->setDefault($this->user->getVerifiedPhone());
        $this->view->form = $fr;
    }

    public function listAction($page = 1) {

        // load the users
        $moshavers = Moshaver::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $moshavers,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'User ID', 'City ID', 'Address', 'Phone', 'Verified', 'Moshaver Type', 'Degree Type', 'Info', 'Status', 'Date'
                ))->
                setFields(array(
                    'id', 'userid', 'cityid', 'address', 'phone', 'verified', 'moshavertypeid', 'degreetypeid', 'info', 'status', 'getDate()'
                ))->
                setEditUrl(
                        'view'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'list');

        $this->view->list = $paginator->getPaginate();
    }

    public function editAction($id) {


        if (!$this->ValidateAccess($id)) {
            // user do not have permission to edut this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // set title
        $this->setTitle('Edit Moshaver');

        $moshaverItem = Moshaver::findFirst($id);

        // create form
        $fr = new MoshaverForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $moshaver = Moshaver::findFirst($id);
                $moshaver->userid = $this->request->getPost('userid', 'string');

                $moshaver->cityid = $this->request->getPost('cityid', 'string');

                $moshaver->address = $this->request->getPost('address', 'string');

                $moshaver->phone = $this->request->getPost('phone', 'string');

                $moshaver->verified = $this->request->getPost('verified', 'string');

                $moshaver->moshavertypeid = $this->request->getPost('moshavertypeid', 'string');

                $moshaver->degreetypeid = $this->request->getPost('degreetypeid', 'string');

                $moshaver->info = $this->request->getPost('info', 'string');

                $moshaver->status = $this->request->getPost('status', 'string');

                $moshaver->date = $this->request->getPost('date', 'string');
                if (!$moshaver->save()) {
                    $moshaver->showErrorMessages($this);
                } else {
                    $moshaver->showSuccessMessages($this, 'Moshaver Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('userid')->setDefault($moshaverItem->userid);
            $fr->get('cityid')->setDefault($moshaverItem->cityid);
            $fr->get('address')->setDefault($moshaverItem->address);
            $fr->get('phone')->setDefault($moshaverItem->phone);
            $fr->get('verified')->setDefault($moshaverItem->verified);
            $fr->get('moshavertypeid')->setDefault($moshaverItem->moshavertypeid);
            $fr->get('degreetypeid')->setDefault($moshaverItem->degreetypeid);
            $fr->get('info')->setDefault($moshaverItem->info);
            $fr->get('status')->setDefault($moshaverItem->status);
            $fr->get('date')->setDefault($moshaverItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {
        $this->view->moshaver = Moshaver::findFirst($id);
    }

    public function getMoshaverID() {
        // TODO fix here
        return 1;
    }

}
