<?php

namespace Simpledom\Frontend\Controllers;

use CreateQuestionForm;
use Moshaver;
use Question;
use Simpledom\Frontend\BaseControllers\ControllerBase;
use UserPhone;

class QuestionController extends ControllerBase {

    protected function ValidateAccess($id) {
        
    }

    public function indexAction($moshaverTypeID) {

        // check if moshavere type is valid
        if (!isset($moshaverTypeID) || intval($moshaverTypeID) == 0) {
            $this->show404();
        }

        // get moshavers for this group type
        $moshavers = Moshaver::find(array("moshavertypeid = :moshavertypeid: AND verified = 1", "bind" => array("moshavertypeid" => $moshaverTypeID)));

        // create question form
        $fr = new CreateQuestionForm();

        // set default
        $fr->get("moshaverid")->setDefault($moshavers->getFirst()->id);

        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {


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
                        $question->showSuccessMessages($this, 'New Question added Successfully');

                        // clear the title and message so the user can add better info
                        $fr->clear();
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

}
