<?php

namespace Simpledom\Frontend\Controllers;

use Answer;
use CreateQuestionForm;
use Moshaver;
use MoshaverType;
use Question;
use SendMoshaverAnswerForm;
use Simpledom\Core\Classes\Order;
use Simpledom\Frontend\BaseControllers\ControllerBase;
use User;
use UserPhone;

class QuestionController extends ControllerBase {

    protected function ValidateAccess($id) {
        
    }

    public function indexAction($moshaverTypeID) {

        // check if moshavere type is valid
        if (!isset($moshaverTypeID) || intval($moshaverTypeID) == 0) {
            $this->show404();
        }

        // set title based on moshaver type
        $moshaverType = MoshaverType::findFirst(array("id = :id:", "bind" => array("id" => $moshaverTypeID)));
        $this->setPageTitle($moshaverType->name);
        $this->view->moshaverType = $moshaverType;

        // get moshavers for this group type
        $moshavers = Moshaver::find(array("moshavertypeid = :moshavertypeid: AND verified = 1", "bind" => array("moshavertypeid" => $moshaverTypeID)));

        // create question form
        $fr = new CreateQuestionForm();

        // set default
        $fr->get("moshaverid")->setDefault($moshavers->getFirst()->id);

        // if user has verified phone, use that for phone
        if (isset($this->user) && $this->getUser()->hasVerifiedPhone()) {
            $fr->get("phone")->setDefault($this->getUser()->getVerifiedPhone());
        }

        // if user is logged in remove unneccery elements
        if (isset($this->user)) {
            $fr->remove("fname");
            $fr->remove("lname");
            $fr->remove("email");
        }

        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {

                $needtoredirectPhoneVerify = false;

                // check if user is not logged in, create user
                if (!$this->session->has("userid")) {

                    // we have to create user
                    $user = new User();
                    $user->email = $this->request->getPost("email", "email");
                    $user->fname = $this->request->getPost("fname");
                    $user->lname = $this->request->getPost("lname");
                    $user->gender = $this->request->getPost("gender");
                    $user->level = USERLEVEL_USER;
                    $password = $user->generateRandomString(12);
                    $user->password = $password;

                    if (!$user->create()) {
                        $this->errors[] = $user->getMessagesAsLines();
                    } else {
                        // user created successfully
                        $user->Login($user->email, $password);

                        // set session
                        $user->setSession($this);

                        // email user password
                    }
                }


                // Check for phone
                $phone = $this->request->getPost('phone', 'string');
                $userPhone = UserPhone::findFirst(array("phone = :phone:", "bind" => array("phone" => $phone)));
                if (!$userPhone) {
                    // we have to create new phone and add that
                    $userPhone = new UserPhone();
                    $userPhone->userid = $this->getUser()->userid;
                    $userPhone->phone = $phone;
                    $userPhone->create();


                    // we have to send verification code to user
                    $userPhone->sendVerificationNumber();

                    $needtoredirectPhoneVerify = true;
                } else {
                    // user phone exist, check for user id
                    if ($userPhone->userid != $this->getUser()->id) {
                        $this->errors[] = "شماره تماس شما توسط شخص دیگری در حال استفاده است";
                    } else {
                        // user phone is valid
                    }
                }

                // check if we have no error in email and user
                if (!$this->hasError()) {
                    // form is valid
                    $question = new Question();
                    $question->moshavertypeid = $moshaverTypeID;
                    $question->userid = $this->user->userid;
                    $question->moshaverid = $this->request->getPost('moshaverid', 'string');
                    $question->question = $this->request->getPost('question', 'string');
                    $question->aboutyourself = $this->request->getPost('aboutyourself', 'string');
                    $question->disorderhistory = $this->request->getPost('disorderhistory', 'string');
                    $question->usingtablet = $this->request->getPost('usingtablet', 'string');
                    $question->cityid = $this->request->getPost('cityid', 'string');
                    if (!$question->create()) {
                        $question->showErrorMessages($this);
                    } else {

                        // show message to user
                        $message = "سوال شما با موفقیت ارسال گردید";
                        if ($needtoredirectPhoneVerify) {

                            // append message
                            $message.= "، برای تایید سوال خود نیاز است تا شماره تماس خود را تایید نمایید.";

                            // show the message
                            $this->flash->notice($message);

                            // redirect to phone verify page
                            $this->dispatcher->forward(array(
                                "controller" => "phone",
                                "action" => "verify",
                                "params" => array($phone)
                            ));

                            // notify of new message
                            $question->notifyOfNewQuestion();
                        } else {

                            // clear the title and message so the user can add better info
                            $fr->clear();

                            // show the message
                            $this->flash->success($message);

                            // notify of new message
                            $question->notifyOfNewQuestion();

                            // redirect to phone verify page
                            $this->dispatcher->forward(array(
                                "controller" => "question",
                                "action" => "view",
                                "params" => array($question->id)
                            ));
                        }
                    }
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }
        $this->handleFormScripts($fr);
        $this->view->form = $fr;

        // load to views
        $this->view->moshavers = $moshavers;
    }

    public function listAction($numberPage = 1) {
        
    }

    public function orderAction($questionID) {
        if (!isset($this->user)) {
            $this->dispatcher->forward(array(
                "controller" => "user",
                "action" => "login",
                "params" => array()
            ));
            return;
        }

        $order = new Order($this->user->userid);
        $orderID = $order->CreateOrder($this->errors, 4, $questionID);
        $order->PayOrder($this->errors, $orderID, 1);
    }

    public function viewAction($questionID) {

        // check if question exist
        $question = Question::findFirst(array("id = :id:", "bind" => array("id" => $questionID)));
        if (!$question) {
            // question not found
            $this->show404();
        }

        // check if question belongs to this user
        if ($question->userid != $this->getUser()->userid) {
            // it is not belong to him\her
            $this->show404();
        }

        // set page title
        $this->setPageTitle("مشاهده سوال");

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

                    // clear the form
                    $form->clear();
                }
            }
        }


        // check if the user paid the money to see the price
        if ($question->isPaid()) {
            // get answers
            $this->view->answers = Answer::find(array("questionid = :questionid:", "order" => "id ASC", "bind" => array("questionid" => $questionID)));

            // set view to true
            $this->view->isPaid = true;
        } else {

            // check if question is answered
            $this->view->isAnswered = $question->isAnswerd();
            
            // set view to false
            $this->view->isPaid = false;
        }


        // show in view
        $this->view->form = $form;
        $this->view->question = $question;
    }

}
