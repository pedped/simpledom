<?php

                        use Phalcon\Mvc\Model\Validator\Email as Email;
                        use Simpledom\Core\AtaModel;

                        class BaseProductType extends AtaModel {

                            public function getSource() {
                                return 'producttype';
                            } 
                            /**
                             * ID
                             * @var string
                             */
                            public $id;

                        /**
                         * Set ID
                         * @param type $id
                         * @return BaseProductType
                         */
                       public function setId($id) {
                            $this->id = $id;
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
                         * @return BaseProductType
                         */
                       public function setKey($key) {
                            $this->key = $key;
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
                         * @return BaseProductType
                         */
                       public function setName($name) {
                            $this->name = $name;
                            return $this;
                       } 
                     
                            /**
                             * Enable
                             * @var string
                             */
                            public $enable;

                        /**
                         * Set Enable
                         * @param type $enable
                         * @return BaseProductType
                         */
                       public function setEnable($enable) {
                            $this->enable = $enable;
                            return $this;
                       } 
                    
                            public function beforeValidationOnCreate() {
                                 
                            }


                            public function beforeValidationOnSave() {
                               
        
                            }

                            public function getPublicResponse() {
        
                            }

                        }


                            