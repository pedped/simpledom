<?php

use Respect\Validation\Validator as v;

class Validating {

    /**
     * Validate User ID
     * @param type $errors
     * @param type $input
     * @return boolean
     */
    public static function ValidateUserID(&$errors, $input) {
        try {
            $input = intval($input);
            v::notEmpty()->numeric()->intType()->min(0)->check($input);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('User ID'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    /**
     * Validate UUID
     * @param type $errors
     * @param type $input
     * @return boolean
     */
    public static function ValidateUUID(&$errors, $input) {
        try {
            v::notEmpty()->length(16)->check($input);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('UUID'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateSearchQuery(&$errors, $query) {
        try {
            v::notEmpty()->length(2)->check($query);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Search Query'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateEmail(&$errors, $email) {
        try {
            v::notEmpty()->email()->check($email);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Email Address'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateNoteAnimationID(&$errors, $cid) {
        try {
            $cid = intval($cid);
            v::notEmpty()->numeric()->intType()->min(0)->check($cid);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Note Animation'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateClassroomID(&$errors, $cid) {
        try {
            $cid = intval($cid);
            v::notEmpty()->numeric()->intType()->min(0)->check($cid);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Classroom ID'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateInt(&$errors, $id, $name) {
        try {
            $id = intval($id);
            v::notEmpty()->numeric()->intType()->min(0)->check($id);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_($name))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateRequestType(&$errors, $type) {
        try {
            $type = intval($type);
            v::notEmpty()->numeric()->intType()->in([_REQUESTTYPE_CLASSROOMJOIN, _REQUESTTYPE_FRIENDSHIP, _REQUESTTYPE_INVITETOCLASSROOM])->check($type);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Request Type'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateFirstName(&$errors, $firstname) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(2, 50)->check($firstname);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('First Name'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateLastName(&$errors, $lastname) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(2, 50)->check($lastname);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Last Name'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateGender(&$errors, $gender) {
        $gender = intval($gender);
        try {
            v::numeric()->intType()->in([0, 1])->check($gender);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Gender'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateCity(&$errors, $city) {
        try {
            v::notEmpty()->stringType()->alnum(",")->charset("UTF-8")->length(2)->check($city);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('City'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateBirthdayDay(&$errors, $b_d) {


        try {
            $b_d = intval($b_d);
            v::numeric()->nullValue()->intType()->between(1, 31)->check($b_d);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Month Day'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateBirthdayMonth(&$errors, $b_m) {

        try {
            $b_m = intval($b_m);
            v::numeric()->intType()->nullValue()->between(1, 12)->check($b_m);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Month'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateBirthdayYear(&$errors, $b_y) {
        try {
            $b_y = intval($b_y);
            v::numeric()->intType()->nullValue()->between(0, 10000)->check($b_y);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Year'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateBoolean(&$errors, $isteacher, $name) {
        try {
            v::boolType()->check($isteacher);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName($name)->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidatePlaceWhereTeach(&$errors, $placewhereteach) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(2)->check($placewhereteach);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Place Where Teach'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidatePlaceWhereStudy(&$errors, $placewherestudy) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(2)->check($placewherestudy);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Place Where Study'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateClassroomTimeID(&$errors, $ctid) {
        try {
            $ctid = intval($ctid);
            v::notEmpty()->numeric()->intType()->min(0)->check($ctid);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Classroom Time ID'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateLikeType(&$errors, $type) {
        require_once 'class.like.php';
        try {
            $type = intval($type);
            v::notEmpty()->numeric()->intType()->in([
                __LIKETYPE_CLASSROOMPOST,
                __LIKETYPE_CLASSROOMQUESTION,
                __LIKETYPE_COMMENT,
                __LIKETYPE_PAGE,
                __LIKETYPE_STATUS,
                __LIKETYPE_USEREVENT,
                __LIKETYPE_CLASSROOMPROJECT,
            ])->check($type);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Like Type'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateCommentType(&$errors, $type) {
        require_once 'class.comment.php';
        try {
            $type = intval($type);
            v::notEmpty()->numeric()->intType()->in([
                __COMMENTTYPE_CLASSROOMPOST,
                __COMMENTTYPE_CLASSROOMQUESTION,
                __COMMENTTYPE_COMMENT,
                __COMMENTTYPE_PAGE,
                __COMMENTTYPE_STATUS,
                __COMMENTTYPE_USEREVENT,
                __COMMENTTYPE_CLASSROOMPROJECT,
            ])->check($type);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Comment Type'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateCommentMessage(&$errors, $message) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(1)->check($message);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Comment'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateReportType(&$errors, $type) {
        try {
            $type = intval($type);
            v::notEmpty()->numeric()->intType()->in([
                REPORT_TYPE_CLASSROOMFILE,
                REPORT_TYPE_CLASSROOMPOST,
                REPORT_TYPE_CLASSROOM,
                REPORT_TYPE_CLASSROOMVOICE,
                REPORT_TYPE_COMMENT,
                REPORT_TYPE_PAGE,
                REPORT_TYPE_STATUS,
                REPORT_TYPE_USER,
            ])->check($type);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Report Type'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateClassroomVoiceTitle(&$errors, $title) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(2, 200)->check($title);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Classroom Voice Title'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateClassroomVoiceID(&$errors, $cvid) {
        try {
            $cvid = intval($cvid);
            v::notEmpty()->numeric()->intType()->min(0)->check($cvid);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Classroom Voice ID'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateClassroomFileID(&$errors, $cfid) {
        try {
            $cfid = intval($cfid);
            v::notEmpty()->numeric()->intType()->min(0)->check($cfid);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Classroom File ID'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateClassroomEventTitle(&$errors, $title) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(2, 50)->check($title);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Classroom Event Title'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateClassroomEventDescription(&$errors, $description) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(10, 1000)->check($description);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Classroom Event Description'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateClassroomTitle(&$errors, $title) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(2, 100)->check($title);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Classroom Title'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateClassroomLevel(&$errors, $level) {
        try {
            $level = intval($level);
            v::numeric()->intType()->in([
                0,
                1,
                2,
            ])->check($level);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Classroom Level'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidatePageTitle(&$errors, $title) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(2, 100)->check($title);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Page Title'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidatePageID(&$errors, $pageid) {
        try {
            $pageid = intval($pageid);
            v::notEmpty()->numeric()->intType()->min(0)->check($pageid);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Page ID'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateStatusID(&$errors, $statusid) {
        try {
            $statusid = intval($statusid);
            v::notEmpty()->numeric()->intType()->min(0)->check($statusid);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Status ID'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateClassroomPostID(&$errors, $cpid) {
        try {
            $cpid = intval($cpid);
            v::notEmpty()->numeric()->intType()->min(0)->check($cpid);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Classroom Post ID'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateGradeType(&$errors, $grade) {
        try {
            v::notEmpty()->in([
                GRADE_IR_AVAL,
                GRADE_IR_DOVOM,
                GRADE_IR_SEVOM,
                GRADE_IR_CHAHAROM,
                GRADE_IR_PANJOM,
                GRADE_IR_SHESHOM,
                GRADE_IR_HAFTOM,
                GRADE_IR_HASHTOM,
                GRADE_IR_NOHOM,
                GRADE_IR_DAHAM,
                GRADE_IR_YAZDAHOM,
                GRADE_IR_DAVAZDAHOM,
                GRADE_IR_LICANCE,
                GRADE_IR_FOGHELICANCE,
                GRADE_IR_DOCTORA,
            ])->check($grade);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Grade'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateGlobalType(&$errors, $globalType) {
        try {
            $globalType = intval($globalType);
            v::notEmpty()->numeric()->intType()->in([
                GLOBALTYPE_USER,
                GLOBALTYPE_CLASSROOM,
                GLOBALTYPE_PAGE,
                GLOBALTYPE_COMMENT,
                GLOBALTYPE_CLASSROOM_VOICE,
                GLOBALTYPE_CLASSROOM_QUESTION,
                GLOBALTYPE_CLASSROOM_POST,
                GLOBALTYPE_STATUS,
                GLOBALTYPE_USEREVENT,
                GLOBALTYPE_LIKE,
            ])->check($globalType);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Item Type'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateOrderID(&$errors, $orderID) {
        try {
            $orderID = intval($orderID);
            v::notEmpty()->numeric()->intType()->min(0)->check($orderID);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Order ID'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidatePageReceiverType(&$errors, $receivertype) {
        //die("not implanted");
        return true;
    }

    public static function ValidateTeacherName(&$errors, $teachername) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(2, 100)->check($teachername);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Teacher Name'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidatePageDescription(&$errors, $description) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(2, 100)->check($description);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Description'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateUniversityName(&$errors, $university) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(2, 100)->check($university);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('University Name'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateAlbumID(&$errors, $albumID) {
        try {
            $albumID = intval($albumID);
            v::notEmpty()->numeric()->intType()->min(0)->check($albumID);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Album ID'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidatePrivateMessageMessage(&$errors, $message) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(1, 50000)->check($message);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Message'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateDayOfWeek(&$errors, $day) {
        return true;
    }

    public static function ValidateClassroomFileTitle(&$errors, $title) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(2, 100)->check($title);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('File Title'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateCommentID(&$errors, $comemntid) {
        try {
            $comemntid = intval($comemntid);
            v::notEmpty()->numeric()->intType()->min(0)->check($comemntid);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Comment ID'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateFacebookUserID(&$errors, $fbuid) {
        try {
            $fbuid = intval($fbuid);
            v::notEmpty()->numeric()->intType()->min(0)->check($fbuid);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Facrbook ID'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateFacebookTokan(&$errors, $fbtoken) {
        try {
            return true;
            v::notEmpty()->stringType()->charset("UTF-8")->length(2, 100)->check($fbtoken);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Facebook Token'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidatePassword(&$errors, $password) {
        // check for password
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(8, 100)->check($password);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Password'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateSkillTitle(&$errors, $title) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(3, 100)->check($title);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Skill Title'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateSkillDescriprion(&$errors, $description) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(2, 100)->check($description);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Skill Description'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateClassroomQuestionID(&$errors, $qid) {


        try {
            $qid = intval($qid);
            v::notEmpty()->numeric()->intType()->min(0)->check($qid);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Classroom Question ID'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateClassroomQuestionAnswer(&$errors, $answer) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(2)->check($answer);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Answer'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateClassroomQuestion(&$errors, $question) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(20)->check($question);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Question'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateClassroomDescription(&$errors, $description) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(20, 100)->check($description);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Classroom Description'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateClassroomDescriptionCanEmpty(&$errors, $description) {
        try {
            v::stringType()->charset("UTF-8")->length(20, 100)->check($description);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Classroom Description'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateYoutubeID(&$errors, $youtubeid) {
        try {
            $youtubeid = intval($youtubeid);
            v::notEmpty()->numeric()->intType()->min(0)->check($youtubeid);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Youtube ID'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidatePrivateMessageID(&$errors, $pmmessageid) {
        try {
            $pmmessageid = intval($pmmessageid);
            v::notEmpty()->numeric()->intType()->min(0)->check($pmmessageid);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Private Message ID'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateStatusReceiverType(&$errors, $receiver) {
        try {
            $receiver = intval($receiver);
            v::notEmpty()->numeric()->intType()->in([
                STATUS_RECEIVERTYPE_PUBLIC,
                STATUS_RECEIVERTYPE_FRIENDS,
                STATUS_RECEIVERTYPE_CLASSMATES,
                STATUS_RECEIVERTYPE_CLASSMATEANDFRIENDS,
                STATUS_RECEIVERTYPE_ONLYUSER,
            ])->check($receiver);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Status Receiver Type'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateStatusMessage(&$errors, $message) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(2)->check($message);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Status Message'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateClassroomPostMessage(&$errors, $message) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(2)->check($message);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Classroom Post'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateSkillLevel(&$errors, $level) {
        try {
            $level = intval($level);
            v::notEmpty()->numeric()->intType()->in([
                1,
                2,
                3
            ])->check($level);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Skill Level'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateProductType(&$errors, $productType) {
        require_once 'class.order.php';
        try {
            $productType = intval($productType);
            v::notEmpty()->numeric()->intType()->in([
                __PRODUCT_CLASSROOMJOIN,
                __PRODUCT_CLASSROOMVOICEACCOUNT,
                __PRODUCT_BECAMESPONSOR
            ])->check($productType);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Product Type'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateAviaryURL(&$errors, $url) {

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            // invalid URL
            $errors[] = _("Invalid Aviary URL");
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidatePrivateKeyAction(&$errors, $action) {
        try {
            $action = intval($action);
            v::notEmpty()->numeric()->intType()->in([
                PRIVATEKEYACTION_CHANGEPROFILECOVER,
                PRIVATEKEYACTION_CHANGECLASSROOMCOVER,
                PRIVATEKEYACTION_CHANGEPROFILEIMAGE,
            ])->check($action);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Private Key Type'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateClassroomPostTitle(&$errors, $title) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(2)->check($title);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Classroom Post Title'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateLanguageID(&$errors, $languageID) {
        try {
            $languageID = intval($languageID);
            v::notEmpty()->numeric()->intType()->in([
                LANGUAGE_CODE_ENGLISH,
                LANGUAGE_CODE_PERSIAN,
            ])->check($languageID);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Language ID'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateShebaNumber(&$errors, $shebanumber) {
        try {
            v::notEmpty()->stringType()->startsWith("IR")->charset("UTF-8")->length(26, 26)->check($shebanumber);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('SHEBA Number'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateClassroomDirectContact($errors, $directcontact) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(10, 250)->check($directcontact);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Classroom Direct Contact Info'))->getMainMessage();
            return false;
        }
        // validate successfull
        return true;
    }

    public static function ValidateAttachID($errors, $attachID) {
        try {
            $attachID = intval($attachID);
            v::notEmpty()->numeric()->intType()->min(0)->check($attachID);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Attachment ID'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateProjectTitle($errors, $projecttitle) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(10, 250)->check($projecttitle);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Project Title'))->getMainMessage();
            return false;
        }
        // validate successfull
        return true;
    }

    public static function ValidateProjectDescription($errors, $projectDescription) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(40)->check($projectDescription);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Project Description'))->getMainMessage();
            return false;
        }
        // validate successfull
        return true;
    }

    public static function ValidateClassroomProjectID($errors, $cprID) {
        try {
            $cprID = intval($cprID);
            v::notEmpty()->numeric()->intType()->min(0)->check($cprID);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Classroom Project ID'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateSponserCost(&$errors, $value, $currency) {
        switch ($currency) {
            case "USD":
                if (intval($value) < 5) {
                    $errors[] = _("Sponsor Price should not be lower than 5 USD");
                    return false;
                } else if (intval($value) > 50000) {
                    $errors[] = _("If you would like to pay more than 50000 USD, please Contact US");
                    return false;
                }

                // valid item
                return true;
            case "IRR":
                if (intval($value) < 50000) {
                    $errors[] = _("Sponsor Price should not be lower than 50000 Rials");
                    return false;
                } else if (intval($value) > 100000000) {
                    $errors[] = _("If you would like to pay more than 100,000,000 Rials, please Contact US");
                    return false;
                }
                // valid item
                return true;
        }

        $errors[] = _("Invalid Currency");
        return false;
    }

    public static function ValidatePublicClassroomType(&$errors, $publicclasstype) {
        try {
            v::notEmpty()->in([
                __PUBLICCLASSROOMTYPE_LEARNING,
                __PUBLICCLASSROOMTYPE_NEWS,
                __PUBLICCLASSROOMTYPE_PRODUCT,
                __PUBLICCLASSROOMTYPE_SHOWCASE,
            ])->check($publicclasstype);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Public Classroom Type'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateSponsorTitle(&$errors, $title) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(2, 200)->check($title);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Sponsor Title'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateSponsorDescription(&$errors, $description) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(10, 2000)->check($description);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Sponsor Description'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidatePhoneConfirmCode(&$errors, $confirmCode) {
        try {
            v::notEmpty()->numeric()->length(4)->check($confirmCode);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Confirm Code'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateUserStatusMessage(&$errors, $userstatus) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(4, 300)->check($userstatus);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Status Message'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidateClassroomSMSMessage(&$errors, $message) {
        try {
            v::notEmpty()->stringType()->charset("UTF-8")->length(10, 256)->check($message);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('SMS Message'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

    public static function ValidatePhone(&$errors, $phone) {
        try {
            v::notEmpty()->numeric()->check($phone);
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->setName(_('Phone'))->getMainMessage();
            return false;
        }

        // validate successfull
        return true;
    }

}
