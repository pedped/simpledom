<?php

                        use Phalcon\Mvc\Model\Validator\Email as Email;
                        use Simpledom\Core\AtaModel;

                        class BaseReceivedSMS extends AtaModel {

                            public function getSource() {
                                return 'receivedsms';
                            } 
                            /**
                             * ID
                             * @var string
                             */
                            public $id;

                        /**
                         * Set ID
                         * @param type $id
                         * @return BaseReceivedSMS
                         */
                       public function setId($id) {
                            $this->id = $id;
                            return $this;
                       } 
                     
                            /**
                             * Phone
                             * @var string
                             */
                            public $phone;

                        /**
                         * Set Phone
                         * @param type $phone
                         * @return BaseReceivedSMS
                         */
                       public function setPhone($phone) {
                            $this->phone = $phone;
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
                         * @return BaseReceivedSMS
                         */
                       public function setMessage($message) {
                            $this->message = $message;
                            return $this;
                       } 
                     
                            /**
                             * From Number
                             * @var string
                             */
                            public $fromnumber;

                        /**
                         * Set From Number
                         * @param type $fromnumber
                         * @return BaseReceivedSMS
                         */
                       public function setFromnumber($fromnumber) {
                            $this->fromnumber = $fromnumber;
                            return $this;
                       } 
                     
                            /**
                             * IP
                             * @var string
                             */
                            public $ip;

                        /**
                         * Set IP
                         * @param type $ip
                         * @return BaseReceivedSMS
                         */
                       public function setIp($ip) {
                            $this->ip = $ip;
                            return $this;
                       } 
                     
                            /**
                             * Provider
                             * @var string
                             */
                            public $provider;

                        /**
                         * Set Provider
                         * @param type $provider
                         * @return BaseReceivedSMS
                         */
                       public function setProvider($provider) {
                            $this->provider = $provider;
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
                         * @return BaseReceivedSMS
                         */
                       public function setDate($date) {
                            $this->date = $date;
                            return $this;
                       } 
                    
                            public function getDate() {
                                return date('Y-m-d H:i:s', $this->date);
                            }

                            public function getUserName() {
                                return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
                            }


                            /**
                            *
                            * @param type $parameters
                            * @return BaseReceivedSMS
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


                            