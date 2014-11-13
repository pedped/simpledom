<?php

                        use Phalcon\Mvc\Model\Validator\Email as Email;
                        use Simpledom\Core\AtaModel;

                        class Post extends AtaModel {

                            public function getSource() {
                                return 'post';
                            } 
                            /**
                             * ID
                             * @var string
                             */
                            public $id;

                        /**
                         * Set ID
                         * @param type $id
                         * @return Post
                         */
                       public function setId($id) {
                            $this->id = $id;
                            return $this;
                       } 
                     
                            /**
                             * Organ ID
                             * @var string
                             */
                            public $organid;

                        /**
                         * Set Organ ID
                         * @param type $organid
                         * @return Post
                         */
                       public function setOrganid($organid) {
                            $this->organid = $organid;
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
                         * @return Post
                         */
                       public function setName($name) {
                            $this->name = $name;
                            return $this;
                       } 
                     
                            /**
                             * Key
                             * @var string
                             */
                            public $key;

                        /**
                         * Set Key
                         * @param type $key
                         * @return Post
                         */
                       public function setKey($key) {
                            $this->key = $key;
                            return $this;
                       } 
                     
                            /**
                             * SMS Kety
                             * @var string
                             */
                            public $smskey;

                        /**
                         * Set SMS Kety
                         * @param type $smskey
                         * @return Post
                         */
                       public function setSmskey($smskey) {
                            $this->smskey = $smskey;
                            return $this;
                       } 
                    

                            /**
                            *
                            * @param type $parameters
                            * @return Post
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


                            