<?php

                        use Phalcon\Mvc\Model\Validator\Email as Email;
                        use Simpledom\Core\AtaModel;

                        class MelkSubscriber extends AtaModel {

                            public function getSource() {
                                return 'melksubscriber';
                            } 
                            /**
                             * ID
                             * @var string
                             */
                            public $id;

                        /**
                         * Set ID
                         * @param type $id
                         * @return MelkSubscriber
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
                         * @return MelkSubscriber
                         */
                       public function setUserid($userid) {
                            $this->userid = $userid;
                            return $this;
                       } 
                     
                            /**
                             * Melk Subscribe ID
                             * @var string
                             */
                            public $melksubscribeitemid;

                        /**
                         * Set Melk Subscribe ID
                         * @param type $melksubscribeitemid
                         * @return MelkSubscriber
                         */
                       public function setMelksubscribeitemid($melksubscribeitemid) {
                            $this->melksubscribeitemid = $melksubscribeitemid;
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
                         * @return MelkSubscriber
                         */
                       public function setDate($date) {
                            $this->date = $date;
                            return $this;
                       } 
                     
                            /**
                             * Order ID
                             * @var string
                             */
                            public $orderid;

                        /**
                         * Set Order ID
                         * @param type $orderid
                         * @return MelkSubscriber
                         */
                       public function setOrderid($orderid) {
                            $this->orderid = $orderid;
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
                            * @return MelkSubscriber
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


                            