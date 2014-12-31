<?php

namespace Simpledom\Api\Controllers;

use Melk;
use MelkPhoneListner;
use stdClass;

class BongahController extends ControllerBase {

    /**
     * @mobile
     */
    public function sendmelkinfoAction() {
        if (!$this->user->isBongahDar()) {
            // return $this->getResponse("You are not bongah dar");
        }

        $ids = $_POST["ids"];
        $phoneListnerID = (int) $_POST["phonelistnerid"];


        // parse ids
        $ids = explode(",", $ids);
        $itemIDs = array();
        foreach ($ids as $value) {
            $itemIDs[] = (int) $value;
        }


        // we have to send melk info
        $bongah = $this->user->getFirstBongah();
        foreach ($itemIDs as $melkID) {
            $bongah->sendMelkInfo($this->errors, $phoneListnerID, $melkID);
            if (count($this->errors) > 0) {
                // return false
                return $this->getResponse(false);
            }
        }

        // success, we have to send user last sms credit
        return $this->getResponse($this->user->getSMSCredit());
    }

    public function fetchmelkcanbesentAction($melkphonelistnerid) {

        if (!$this->user->isBongahDar()) {
            // return $this->getResponse("You are not bongah dar");
        }

        // find phone listner
        $phonelistner = MelkPhoneListner::findFirst(array("id = :id:", "bind" => array("id" => $melkphonelistnerid)));
        if (!$phonelistner) {
            $this->show404();
            return;
        }


        // find melks
        $melks = $phonelistner->findApprochMelk($this->user->getFirstBongah()->id);
        $items = array();
        foreach ($melks as $melk) {
            $items[] = $melk->getBongahResponse();
        }
        return $this->
                        getResponse($items);
    }

    /**
     * @mobile
     */
    public function getusercreditAction() {


        if (!$this->user->isBongahDar()) {
            // return $this->getResponse("You are not bongah dar");
        }

        $result = new stdClass();
        $result->remaindays = $this->user->getFirstBongah()->getRemainingPlanDays();
        $result->smscredit = $this->user->getSMSCredit();
        $result->melks = $this->user->getFirstBongah()->getMelksCount();
        return $this->getResponse($result);
    }

    /**
     * @mobile
     * @return type
     */
    public function getnewrequestAction() {

        $lastSeenID = (int) $_POST["lastid"];

        //var_dump($this->user->fname);
        // check if the user is bonagh dar
        if (!$this->user->isBongahDar()) {
            // return $this->getResponse("You are not bongah dar");
        }

        // get bongah
        $bongah = $this->user->getFirstBongah();

        // find all city
        $melkphonelistners = MelkPhoneListner::find(
                        array(
                            'id > :id: AND cityid = :cityid: AND status = "1"',
                            'order' => 'id DESC',
                            "bind" => array(
                                "id" => $lastSeenID,
                                "cityid" => $bongah->cityid
                            )
        ));

        $items = array();
        foreach ($melkphonelistners as $value) {
            $items[] = $value->getMobileResponse($bongah);
        }
        return $this->getResponse($items);
    }

    /**
     * @mobile
     * @return type
     */
    public function getmelkrequestAction() {

        $start = (int) $_POST["start"];
        $limit = (int) $_POST["limit"];

        //var_dump($this->user->fname);
        // check if the user is bonagh dar
        if (!$this->user->isBongahDar()) {
            // return $this->getResponse("You are not bongah dar");
        }

        // get bongah
        $bongah = $this->user->getFirstBongah();

        // find all city
        $melkphonelistners = MelkPhoneListner::find(
                        array(
                            'cityid = :cityid: AND status = "1"',
                            'order' => 'id DESC',
                            "limit" => $start . " , " . $limit,
                            "bind" => array(
                                "cityid" => $bongah->cityid
                            )
        ));

        $items = array();
        foreach ($melkphonelistners as $value) {
            $items[] = $value->getMobileResponse($bongah);
        }
        return $this->getResponse($items);
    }

    public function getmelksAction() {
        $start = (int) $_POST["start"];
        $limit = (int) $_POST["limit"];

        //var_dump($this->user->fname);
        // check if the user is bonagh dar
        if (!$this->user->isBongahDar()) {
            //return $this->getResponse("You are not bongah dar");
        }

        // get bongah
        $bongah = $this->user->getFirstBongah();

        // find all city
        $melks = Melk::find(
                        array(
                            'userid = :userid:',
                            'order' => 'id DESC',
                            "limit" => $start . " , " . $limit,
                            "bind" => array(
                                "userid" => $this->user->userid
                            )
        ));

        $items = array();
        foreach ($melks as $melk) {
            $items[] = $melk->getBongahResponse();
        }
        return $this->getResponse($items);
    }

}
