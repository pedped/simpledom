<?php

                        use Phalcon\Mvc\Model\Validator\Email as Email;
                        use Simpledom\Core\AtaModel;

                        class BaseUserTransaction extends AtaModel {

                            public function getSource() {
                                return 'usertransaction';
                            } 
                            /**
                             * ID
                             * @var string
                             */
                            public $id;

                        /**
                         * Set ID
                         * @param type $id
                         * @return BaseUserTransaction
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
                         * @return BaseUserTransaction
                         */
                       public function setUserid($userid) {
                            $this->userid = $userid;
                            return $this;
                       } 
                     
                            /**
                             * Amount
                             * @var string
                             */
                            public $amount;

                        /**
                         * Set Amount
                         * @param type $amount
                         * @return BaseUserTransaction
                         */
                       public function setAmount($amount) {
                            $this->amount = $amount;
                            return $this;
                       } 
                     
                            /**
                             * Currency
                             * @var string
                             */
                            public $cur;

                        /**
                         * Set Currency
                         * @param type $cur
                         * @return BaseUserTransaction
                         */
                       public function setCur($cur) {
                            $this->cur = $cur;
                            return $this;
                       } 
                     
                            /**
                             * Type
                             * @var string
                             */
                            public $type;

                        /**
                         * Set Type
                         * @param type $type
                         * @return BaseUserTransaction
                         */
                       public function setType($type) {
                            $this->type = $type;
                            return $this;
                       } 
                     
                            /**
                             * Type Name
                             * @var string
                             */
                            public $typename;

                        /**
                         * Set Type Name
                         * @param type $typename
                         * @return BaseUserTransaction
                         */
                       public function setTypename($typename) {
                            $this->typename = $typename;
                            return $this;
                       } 
                     
                            /**
                             * Item ID
                             * @var string
                             */
                            public $itemid;

                        /**
                         * Set Item ID
                         * @param type $itemid
                         * @return BaseUserTransaction
                         */
                       public function setItemid($itemid) {
                            $this->itemid = $itemid;
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
                         * @return BaseUserTransaction
                         */
                       public function setDate($date) {
                            $this->date = $date;
                            return $this;
                       } 
                    
                            public function getDate() {
                                return date('Y-m-d H:m:s', $this->date);
                            }

                            public function beforeValidationOnCreate() {
                                 $this->date = time();
                            }


                            public function beforeValidationOnSave() {
                               
        
                            }

                            public function getPublicResponse() {
        
                            }

                        }


                            