<?php

namespace Simpledom\Core\Classes;

use Organ;
use OrganSentMessage;
use Post;
use SendPermission;
use SMSCredit;
use SMSManager;
use SmsNumber;
use UserPhone;
use UserPost;

class ParsedHeader {

    public $smsKey;
    public $code;

}

class NotifySMSManager {

    public static function onNewMessageReceived(&$errors, $smsNumber, $phone, $message) {

        // check for smsNumber
        $smsnum = SmsNumber::findFirst(array("number = :number:", "bind" => array("number" => $smsNumber)));
        if (!$smsnum) {
            $errors[] = "SMS Number is not exist in our database";
            return;
        }

        // (1) Get Organ
        $organ = Organ::findFirst(array("smsnumberid = :smsnumberid:", "bind" => array("smsnumberid" => $smsnum->id)));
        if (!$organ) {
            // message received for non existnece phone in organs
            $errors[] = "invalid orgain id";
            return false;
        }


        // (2) check for message to know it is correct or not, check for line one
        // and parse them
        $parsedMessageByLine = explode("\n", $message);
        $userMessage = implode("\n", array_slice($parsedMessageByLine, 1));

        // (3) parse line one
        $parsedHeader = self::parseHeader($parsedMessageByLine[0]);

        // (4) Check Sender Post In Organ
        $senderUserPost = UserPost::findFirst(array("phonenumber = :phonenumber:", "bind" => array("phonenumber" => $phone)));
        if (!$senderUserPost) {
            // this post is not exist for the user
            $errors[] = "this post is not exist for the user";
            return;
        }


        $senderPost = Post::findFirst($senderUserPost->postid);

        // create header based on sender
        $header = self::createHeader($senderPost, $senderUserPost);


        // (5) Check receiver حخسف
        $receiverPost = Post::findFirst(array(
                    "organid = :organid: AND smskey = :smskey:",
                    "bind" => array(
                        "organid" => $organ->id,
                        "smskey" => $parsedHeader->smsKey
                    )
        ));
        var_dump($parsedHeader);

        if (!$receiverPost) {
            // receiver post is not exist
            $errors[] = "receiver post is not exist : " . $parsedHeader->smsKey;
            return;
        }

        $receivers = UserPost::find(array("postid = :postid: AND code = :code:", "bind" => array(
                        "postid" => $receiverPost->id,
                        "code" => $parsedHeader->code,
        )));
        if ($receivers->count() == 0) {
            // receiver is not exist
            $errors[] = "receiver is not exist";
            return;
        }


        // check if the sender can send message to receiver
        $sendPermission = SendPermission::findFirst(array("userpost1 = :userpost1: AND userpost2 = :userpost2:", "bind" => array(
                        "userpost1" => $senderPost->id,
                        "userpost2" => $receiverPost->id,
        )));
        if (!$sendPermission || intval($sendPermission->cansend) == 0) {
            // user do not have permission to send message
            $errors[] = "user do not have permission to send message";
            return;
        }

        // Create a message that have to be sent
        $messageToBeSent = self::createMessage($header, $userMessage);

        var_dump($receivers->toArray());
        // send message to each recivers
        foreach ($receivers as $receiver) {

            // var_dump($receiver->toArray());
            // get user phone
            $phoneNumber = $receiver->phonenumber;
            //var_dump($receiver->toArray(), "Message have to be send to " . $phoneNumber);
            // TODO fix sms number [SmsNumber::findFirst()->id to $smsnum->id]
            $smsSender = SmsNumber::findFirst();
            $smsID = SMSManager::SendSMS($phoneNumber, $messageToBeSent, $smsSender->id);
            if ($smsID) {
                // TODO calc sms cost and user for total sms
                SMSCredit::decreaseCredit($errors, $organ->byuserid, $smsID, 1);
            }

            // log sent message
            self::logNewSentMessage($organ->id, $phone, $phoneNumber, $messageToBeSent, $smsSender->number);
            var_dump("sent", $messageToBeSent);
            $errors[] = _("Message Sent!");
        }
    }

    /**
     * Create a message that have to be sent
     * @param type $header
     * @param type $userMessage
     * @return type
     */
    public static function createMessage($header, $userMessage) {
        return $header . "\n" . $userMessage;
    }

    /**
     * create a header
     * @param Post $senderPost
     * @param UserPost $senderUserPost
     */
    public static function createHeader($senderPost, $senderUserPost) {
        $message = "پیام جدید از ";
        $message .= $senderPost->name;

        // check if user has code
        if (intval($senderUserPost->code) > 0) {
            $message .= " ";
            $message .= "کد " . $senderUserPost->code;
        }

        return $message;
    }

    /**
     * Parse Recived SMS Header
     * @param type $header
     * @return ParsedHeader
     */
    public static function parseHeader($header) {


        // trim line one
        $header = trim($header);

        // fix k and y
        $header = str_replace("ك", "ک", str_replace("ي", "ی", $header));

        // explode line one
        $lineOneArray = explode(" ", $header);

        // check if we may have user code
        if (count($lineOneArray) == 1) {
            // we surly have no user code
            $parsedMessage = new ParsedHeader();
            $parsedMessage->smsKey = $lineOneArray[0];
            $parsedMessage->code = 0;
            return $parsedMessage;
        } else {
            // we have to check for last item
            $lastKeyword = $lineOneArray[count($lineOneArray) - 1];
            var_dump($lastKeyword);
            if (intval($lastKeyword) > 0) {
                // we have user code
                $parsedMessage = new ParsedHeader();
                $parsedMessage->smsKey = implode(" ", array_slice($lineOneArray, 0, count($lineOneArray) - 1));
                $parsedMessage->code = intval($lastKeyword);
                return $parsedMessage;
            } else {
                // we do not have user code
                $parsedMessage = new ParsedHeader();
                $parsedMessage->smsKey = implode(" ", array_slice($lineOneArray, 0, count($lineOneArray) - 0));
                $parsedMessage->code = 0;
                return $parsedMessage;
            }
        }
    }

    public static function logNewSentMessage($organID, $fromNumber, $toNumber, $message, $senderNumber) {

        $sentMessage = new OrganSentMessage();
        // TODO calc cost
        $sentMessage->cost = 1;
        $sentMessage->fromnumber = $fromNumber;
        $sentMessage->message = $message;
        $sentMessage->organid = $organID;
        $sentMessage->sendernumber = $senderNumber;
        $sentMessage->tonumber = $toNumber;
        $sentMessage->create();
    }

}
