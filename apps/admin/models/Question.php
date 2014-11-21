<?php

use Simpledom\Core\AtaModel;
use Simpledom\Core\Classes\Config;
use Simpledom\Core\Classes\Helper;

class Question extends AtaModel implements Orderable {

    public function getSource() {
        return 'question';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return Question
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * User ID
     * @var string
     */
    public $userid;

    /**
     * Set User ID
     * @param type $userid
     * @return Question
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * Moshaver ID
     * @var string
     */
    public $moshaverid;

    /**
     * Set Moshaver ID
     * @param type $moshaverid
     * @return Question
     */
    public function setMoshaverid($moshaverid) {
        $this->moshaverid = $moshaverid;
        return $this;
    }

    /**
     * Question
     * @var string
     */
    public $question;

    /**
     * Set Question
     * @param type $question
     * @return Question
     */
    public function setQuestion($question) {
        $this->question = $question;
        return $this;
    }

    /**
     * About Yourself
     * @var string
     */
    public $aboutyourself;

    /**
     * Set About Yourself
     * @param type $aboutyourself
     * @return Question
     */
    public function setAboutyourself($aboutyourself) {
        $this->aboutyourself = $aboutyourself;
        return $this;
    }

    /**
     * Disorder History
     * @var string
     */
    public $disorderhistory;

    /**
     * Set Disorder History
     * @param type $disorderhistory
     * @return Question
     */
    public function setDisorderhistory($disorderhistory) {
        $this->disorderhistory = $disorderhistory;
        return $this;
    }

    /**
     * Using Tablet
     * @var string
     */
    public $usingtablet;

    /**
     * Set Using Tablet
     * @param type $usingtablet
     * @return Question
     */
    public function setUsingtablet($usingtablet) {
        $this->usingtablet = $usingtablet;
        return $this;
    }

    /**
     * City ID
     * @var string
     */
    public $cityid;

    /**
     * Set City ID
     * @param type $cityid
     * @return Question
     */
    public function setCityid($cityid) {
        $this->cityid = $cityid;
        return $this;
    }

    /**
     * Date
     * @var string
     */
    public $date;

    /**
     * Set Date
     * @param type $date
     * @return Question
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:m:s', $this->date);
    }

    public $moshavertypeid;
    public $age;
    public $gender;

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     * 
     * @return User
     */
    public function getUser() {
        return User::findFirst($this->userid);
    }

    /**
     *
     * @param type $parameters
     * @return Question
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

    /**
     * check if the question is answered
     * @return boolean
     */
    public function isAnswerd() {
        return Answer::count(array("questionid = :questionid:", "bind" => array("questionid" => $this->id))) > 0;
    }

    /**
     * 
     * @return string
     */
    public function getCityName() {
        return City::findFirst($this->cityid)->name;
    }

    /**
     * 
     * @return Moshaver
     */
    public function getMoshaver() {
        return Moshaver::findFirst(array("id = :id:", "bind" => array("id" => $this->moshaverid)));
    }

    public function getMoshaverType() {
        return MoshaverType::findFirst(array("id = :id:", "bind" => array("id" => $this->moshavertypeid)));
    }

    public function getAnswerState() {
        // check for answer count
        $answers = Answer::find(array("questionid = :questionid:", "bind" => array("questionid" => $this->id)));
        if ($answers->Count() == 0) {
            return "<div class='btn btn-default btn-sm disabled'>منتظر ارسال پاسخ مشاور</div>";
        } else if ($answers->getLast()->userid == $this->userid) {
            return "<div class='btn btn-warning btn-sm disabled'>پاسخ سوال کننده</div>";
        } else {
            return "<div class='btn btn-success btn-sm disabled'>پاسخ داده شده</div>";
        }
    }

    public function getAnswerButton() {
        $url = $this->getDI()->getUrl()->getBaseUri();
        return "<a href='$url" . "moshaver/question/$this->id' class='btn btn-primary btn-sm'>ارسال جواب</a>";
    }

    public function notifyOfNewQuestion() {

        $emailItems = new EmailItems();

        // send email to moshaver
        $emailItems->sendNewQuestionReceivedToMoshaver($this->getMoshaver()->getUser()->email, $this->getMoshaver()->getUserName(), $this->getMoshaver()->userid, $this->getMoshaverType()->name, $this->getUserName(), $this->userid, $this->question, $this->id);

        // send email to user
        $emailItems->sendNewQuestionReceivedToUser($this->getUser()->email, $this->getUserName(), $this->userid, $this->question, $this->id);

        // send sms to moshaver
        $websiteName = Settings::Get()->websitename;
        SMSManager::SendSMS($this->getMoshaver()->getUser()->getVerifiedPhone(), "شما یک درخواست مشاوره جدید دارید، لطفا به پنل کاربری خود در $websiteName مراجعه فرمایید", SmsNumber::findFirst()->id);

        // send sms to user
        $message = "سوال شما به مشاور ارسال گردید، به زودی پاسخ خود را دریافت خواهید نمود.\nبا تشکر\n$websiteName";
        SMSManager::SendSMS($this->getUser()->getVerifiedPhone(), $message, SmsNumber::findFirst()->id);
    }

    /**
     * check if the user paid the price
     * @return boolean
     */
    public function isPaid() {
        $order = UserOrder::findFirst(
                        array("userid = :userid: AND type = :type: AND itemid = :itemid: AND done = 1",
                            "bind" => array(
                                "userid" => $this->userid,
                                "type" => ProductType::findFirst(array("key = :key:", "bind" => array("key" => "Question")))->id,
                                "itemid" => $this->id,
                            )
                        )
        );

        return isset($order) && $order != FALSE;
    }

    /*     * ********************************************************************
     * ORDER INFO
     *     ********************************************************************** */

    /**
     * 
     * @param type $id
     */
    public static function CheckAvailableToOrder($id) {
        return !$this->isPaid();
    }

    public static function GetCost($id) {
        $item = new stdClass();
        $item->Price = Config::GetMoshaverehPrice();
        $item->Currency = "IRR";
        return $item;
    }

    public static function GetOrderTitle($id) {
        return "حق الزحمه مشاوره";
    }

    public static function ValidateOrderCreateRequest(&$errors, $id) {
        return true;
    }

    public static function getOrderObjectInfo($id) {
        $item = new stdClass();
        $item->title = "حق الزحمه مشاوره";
        $item->description = "هزینه مشاور جهت مشاهده جواب سوالات";
        $item->Cost = new stdClass();
        $item->Cost->Price = Config::GetMoshaverehPrice();
        $item->Cost->Currency = "IRR";
        return $item;
    }

    public static function onSuccessOrder(&$errors, $userid, $id, $orderid = null) {
        // user paid the price, notify of user payment
        $message = "با تشکر از پرداخت شما، هم اکنون میتوانید جواب مشاور را مشاهده نمایید";
        SMSManager::SendSMS(User::findFirst($userid)->getVerifiedPhone(), $message, SmsNumber::findFirst()->id);


        // get question
        $question = Question::findFirst($id);

        // add user payment to moshaver sells
        $moshaverSell = new MoshaverSale();
        $moshaverSell->orderid = $orderid;
        $moshaverSell->userid = $question->moshaverid;
        $moshaverSell->percent = "0.5";
        $moshaverSell->value = Config::GetMoshaverehPrice() * 0.5;
        $moshaverSell->create();

        // forward user to question
        Helper::RedirectToURL("http://www.moshavereh.co/question/view/" . $id);
    }

    /**
     * return splitted and minified part of question
     * @param int $maxLength
     * @return string
     */
    public function getSmallQuestion($maxLength = 120) {
        return strlen($this->question) > $maxLength ? mb_substr($this->question, 0, $maxLength) . "..." : $this->question;
    }

}
