<?php

                        use Phalcon\Mvc\Model\Validator\Email as Email;
                        use Simpledom\Core\AtaModel;

                        class MelkImage extends AtaModel {

                            public function getSource() {
                                return 'melkimage';
                            } 
                            /**
                             * ID
                             * @var string
                             */
                            public $id;

                        /**
                         * Set ID
                         * @param type $id
                         * @return MelkImage
                         */
                       public function setId($id) {
                            $this->id = $id;
                            return $this;
                       } 
                     
                            /**
                             * Melk ID
                             * @var string
                             */
                            public $melkid;

                        /**
                         * Set Melk ID
                         * @param type $melkid
                         * @return MelkImage
                         */
                       public function setMelkid($melkid) {
                            $this->melkid = $melkid;
                            return $this;
                       } 
                     
                            /**
                             * Image ID
                             * @var string
                             */
                            public $imageid;

                        /**
                         * Set Image ID
                         * @param type $imageid
                         * @return MelkImage
                         */
                       public function setImageid($imageid) {
                            $this->imageid = $imageid;
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
                         * @return MelkImage
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
                            * @return MelkImage
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


                            