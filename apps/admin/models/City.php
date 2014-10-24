<?php

                        use Phalcon\Mvc\Model\Validator\Email as Email;
                        use Simpledom\Core\AtaModel;

                        class City extends AtaModel {

                            public function getSource() {
                                return 'city';
                            } 
                            /**
                             * ID
                             * @var string
                             */
                            public $id;

                        /**
                         * Set ID
                         * @param type $id
                         * @return City
                         */
                       public function setId($id) {
                            $this->id = $id;
                            return $this;
                       } 
                     
                            /**
                             * State ID
                             * @var string
                             */
                            public $stateid;

                        /**
                         * Set State ID
                         * @param type $stateid
                         * @return City
                         */
                       public function setStateid($stateid) {
                            $this->stateid = $stateid;
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
                         * @return City
                         */
                       public function setName($name) {
                            $this->name = $name;
                            return $this;
                       } 
                    

                            /**
                            *
                            * @param type $parameters
                            * @return City
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


                            