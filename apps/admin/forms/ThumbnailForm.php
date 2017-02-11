<?php

                                use Phalcon\Forms\Element\Submit;
                                use Phalcon\Validation\Validator\PresenceOf;
                                use Simpledom\Core\AtaForm;

                                class ThumbnailForm extends AtaForm {

                                    public function initialize() {

                            
                            // ID
                            $id = new TextElement('id');
                            $id->setLabel('ID');
                            //$id->setAttribute('placeholder', 'Enter your ID');
                            $id->setAttribute('class', 'form-control');
                            $this->add($id);
                        

                            // Original Image ID
                            $originalimageid = new TextElement('originalimageid');
                            $originalimageid->setLabel('Original Image ID');
                            //$originalimageid->setAttribute('placeholder', 'Enter your Original Image ID');
                            $originalimageid->setAttribute('class', 'form-control');$originalimageid->addValidator(new PresenceOf(array(
                       
                            )));$this->add($originalimageid);


                            // Scale ID
                            $scaleid = new TextElement('scaleid');
                            $scaleid->setLabel('Scale ID');
                            //$scaleid->setAttribute('placeholder', 'Enter your Scale ID');
                            $scaleid->setAttribute('class', 'form-control');$scaleid->addValidator(new PresenceOf(array(
                       
                            )));$this->add($scaleid);


                            // Output Image ID
                            $outputimageid = new TextElement('outputimageid');
                            $outputimageid->setLabel('Output Image ID');
                            //$outputimageid->setAttribute('placeholder', 'Enter your Output Image ID');
                            $outputimageid->setAttribute('class', 'form-control');$outputimageid->addValidator(new PresenceOf(array(
                       
                            )));$this->add($outputimageid);

                                        // Submit Button
                                        $submit = new Submit('submit');
                                        $submit->setName('submit');
                                        $submit->setAttribute('class', 'btn btn-primary');
                                        $this->add($submit);
                                    }

                                }


                          