<?php

                        use Phalcon\Mvc\Model\Validator\Email as Email;
                        use Simpledom\Core\AtaModel;

                        class MelkCreatedBy extends AtaModel {

                            public function getSource() {
                                return 'melkcreatedby';
                            } 
                            /**
                             * ID
                             * @var string
                             */
                            public $id;

                        /**
                         * Set ID
                         * @param type $id
                         * @return MelkCreatedBy
                         */
                       public function setId($id) {
                            $this->id = $id;
                            return $this;
                       } 
                     
                            /**
                             * Name
                             * @var string
                             */
                            public $name;

                        /**
                         * Set Name
                         * @param type $name
                         * @return MelkCreatedBy
                         */
                       public function setName($name) {
                            $this->name = $name;
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
                         * @return MelkCreatedBy
                         */
                       public function setDate($date) {
                            $this->date = $date;
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
                            * @return MelkCreatedBy
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


                            