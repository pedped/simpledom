<?php

                        use Phalcon\Mvc\Model\Validator\Email as Email;
                        use Simpledom\Core\AtaModel;

                        class Tempuser extends AtaModel {

                            public function getSource() {
                                return 'tempuser';
                            } 
                            /**
                             * ID
                             * @var string
                             */
                            public $id;

                        /**
                         * Set ID
                         * @param type $id
                         * @return Tempuser
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
                         * @return Tempuser
                         */
                       public function setUserid($userid) {
                            $this->userid = $userid;
                            return $this;
                       } 
                     
                            /**
                             * Password
                             * @var string
                             */
                            public $password;

                        /**
                         * Set Password
                         * @param type $password
                         * @return Tempuser
                         */
                       public function setPassword($password) {
                            $this->password = $password;
                            return $this;
                       } 
                     
                            /**
                             * Bongah Amlak ID
                             * @var string
                             */
                            public $bongahamlakid;

                        /**
                         * Set Bongah Amlak ID
                         * @param type $bongahamlakid
                         * @return Tempuser
                         */
                       public function setBongahamlakid($bongahamlakid) {
                            $this->bongahamlakid = $bongahamlakid;
                            return $this;
                       } 
                    

                            /**
                            *
                            * @param type $parameters
                            * @return Tempuser
                            */
                            public static function findFirst($parameters = null) {
                                return parent::findFirst($parameters);
                            }
                
                            public function beforeValidationOnCreate() {
                                 
                            }


                            public function beforeValidationOnSave() {
                               
                            }

                            public function getPublicResponse() {
        
                            }

                        }


                            