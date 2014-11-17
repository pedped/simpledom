<?php

                        use Phalcon\Mvc\Model\Validator\Email as Email;
                        use Simpledom\Core\AtaModel;

                        class Answer extends AtaModel {

                            public function getSource() {
                                return 'answer';
                            } 
                            /**
                             * ID
                             * @var string
                             */
                            public $id;

                        /**
                         * Set ID
                         * @param type $id
                         * @return Answer
                         */
                       public function setId($id) {
                            $this->id = $id;
                            return $this;
                       } 
                     
                            /**
                             * Question ID
                             * @var string
                             */
                            public $questionid;

                        /**
                         * Set Question ID
                         * @param type $questionid
                         * @return Answer
                         */
                       public function setQuestionid($questionid) {
                            $this->questionid = $questionid;
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
                         * @return Answer
                         */
                       public function setUserid($userid) {
                            $this->userid = $userid;
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
                         * @return Answer
                         */
                       public function setDate($date) {
                            $this->date = $date;
                            return $this;
                       } 
                     
                            /**
                             * Message
                             * @var string
                             */
                            public $message;

                        /**
                         * Set Message
                         * @param type $message
                         * @return Answer
                         */
                       public function setMessage($message) {
                            $this->message = $message;
                            return $this;
                       } 
                     
                            /**
                             * Delete
                             * @var string
                             */
                            public $delete;

                        /**
                         * Set Delete
                         * @param type $delete
                         * @return Answer
                         */
                       public function setDelete($delete) {
                            $this->delete = $delete;
                            return $this;
                       } 
                    
                            public function getDate() {
                                return date('Y-m-d H:m:s', $this->date);
                            }

                            public function getUserName() {
                                return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
                            }


                            /**
                            *
                            * @param type $parameters
                            * @return Answer
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

                        }


                            