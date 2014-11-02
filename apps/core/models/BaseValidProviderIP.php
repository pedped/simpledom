<?php

                        use Phalcon\Mvc\Model\Validator\Email as Email;
                        use Simpledom\Core\AtaModel;

                        class BaseValidProviderIP extends AtaModel {

                            public function getSource() {
                                return 'validproviderip';
                            } 
                            /**
                             * ID
                             * @var string
                             */
                            public $id;

                        /**
                         * Set ID
                         * @param type $id
                         * @return BaseValidProviderIP
                         */
                       public function setId($id) {
                            $this->id = $id;
                            return $this;
                       } 
                     
                            /**
                             * Provider
                             * @var string
                             */
                            public $providerid;

                        /**
                         * Set Provider
                         * @param type $providerid
                         * @return BaseValidProviderIP
                         */
                       public function setProviderid($providerid) {
                            $this->providerid = $providerid;
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
                         * @return BaseValidProviderIP
                         */
                       public function setIp($ip) {
                            $this->ip = $ip;
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
                         * @return BaseValidProviderIP
                         */
                       public function setEnable($enable) {
                            $this->enable = $enable;
                            return $this;
                       } 
                    

                            /**
                            *
                            * @param type $parameters
                            * @return BaseValidProviderIP
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


                            