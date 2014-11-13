<?php

                        use Phalcon\Mvc\Model\Validator\Email as Email;
                        use Simpledom\Core\AtaModel;

                        class SpecialNumberPlans extends AtaModel {

                            public function getSource() {
                                return 'specialnumberplans';
                            } 
                            /**
                             * ID
                             * @var string
                             */
                            public $id;

                        /**
                         * Set ID
                         * @param type $id
                         * @return SpecialNumberPlans
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
                         * @return SpecialNumberPlans
                         */
                       public function setName($name) {
                            $this->name = $name;
                            return $this;
                       } 
                     
                            /**
                             * Length
                             * @var string
                             */
                            public $length;

                        /**
                         * Set Length
                         * @param type $length
                         * @return SpecialNumberPlans
                         */
                       public function setLength($length) {
                            $this->length = $length;
                            return $this;
                       } 
                     
                            /**
                             * Pre Code
                             * @var string
                             */
                            public $precode;

                        /**
                         * Set Pre Code
                         * @param type $precode
                         * @return SpecialNumberPlans
                         */
                       public function setPrecode($precode) {
                            $this->precode = $precode;
                            return $this;
                       } 
                     
                            /**
                             * Price
                             * @var string
                             */
                            public $price;

                        /**
                         * Set Price
                         * @param type $price
                         * @return SpecialNumberPlans
                         */
                       public function setPrice($price) {
                            $this->price = $price;
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
                         * @return SpecialNumberPlans
                         */
                       public function setEnable($enable) {
                            $this->enable = $enable;
                            return $this;
                       } 
                    

                            /**
                            *
                            * @param type $parameters
                            * @return SpecialNumberPlans
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


                            