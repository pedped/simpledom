<?php

                        use Phalcon\Mvc\Model\Validator\Email as Email;
                        use Simpledom\Core\AtaModel;

                        class MelkFacilities extends AtaModel {

                            public function getSource() {
                                return 'melkfacilities';
                            } 
                            /**
                             * ID
                             * @var string
                             */
                            public $id;

                        /**
                         * Set ID
                         * @param type $id
                         * @return MelkFacilities
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
                         * @return MelkFacilities
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
                         * @return MelkFacilities
                         */
                       public function setDate($date) {
                            $this->date = $date;
                            return $this;
                       } 
                     
                            /**
                             * Image
                             * @var string
                             */
                            public $imageid;

                        /**
                         * Set Image
                         * @param type $imageid
                         * @return MelkFacilities
                         */
                       public function setImageid($imageid) {
                            $this->imageid = $imageid;
                            return $this;
                       } 
                    
                            public function getDate() {
                                return date('Y-m-d H:m:s', $this->date);
                            }

                            public function getUserName() {
                                return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
                            }

                             /**
                             * return the image object
                             * @return BaseImage
                             */
                            public function getImage() {
                                return BaseImage::findFirst($this->imageid);
                            }

                              /**
                             * return the image link
                             * @return String imagelink
                             */
                             public function getImageLink() {
                                return $this->getImage()->link;
                            }


                            /**
                            *
                            * @param type $parameters
                            * @return MelkFacilities
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


                            