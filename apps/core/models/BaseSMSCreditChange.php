<?php

                        use Phalcon\Mvc\Model\Validator\Email as Email;
                        use Simpledom\Core\AtaModel;

                        class BaseSMSCreditChange extends AtaModel {

                            public function getSource() {
                                return 'smscreditchange';
                            } 
                            /**
                             * ID
                             * @var string
                             */
                            public $id;

                        /**
                         * Set ID
                         * @param type $id
                         * @return BaseSMSCreditChange
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
                         * @return BaseSMSCreditChange
                         */
                       public function setUserid($userid) {
                            $this->userid = $userid;
                            return $this;
                       } 
                     
                            /**
                             * SMS ID
                             * @var string
                             */
                            public $smsid;

                        /**
                         * Set SMS ID
                         * @param type $smsid
                         * @return BaseSMSCreditChange
                         */
                       public function setSmsid($smsid) {
                            $this->smsid = $smsid;
                            return $this;
                       } 
                     
                            /**
                             * Value
                             * @var string
                             */
                            public $value;

                        /**
                         * Set Value
                         * @param type $value
                         * @return BaseSMSCreditChange
                         */
                       public function setValue($value) {
                            $this->value = $value;
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
                         * @return BaseSMSCreditChange
                         */
                       public function setDate($date) {
                            $this->date = $date;
                            return $this;
                       } 
                    
                            public function getDate() {
                                return date('Y-m-d H:i:s', $this->date);
                            }

                            public function beforeValidationOnCreate() {
                                 $this->date = time();
                            }


                            public function beforeValidationOnSave() {
                               
        
                            }

                            public function getPublicResponse() {
        
                            }

                        }


                            