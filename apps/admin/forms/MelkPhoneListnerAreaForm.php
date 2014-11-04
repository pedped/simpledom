<?php

                                 ;
                                use TextElement;
                                use EditorElement;
                                use MapElement;
                                use Phalcon\Forms\Element\Select;
                                use Phalcon\Forms\Element\Submit;
                                use Phalcon\Forms\Element\Text;
                                use Phalcon\Validation\Validator\Email;
                                use Phalcon\Validation\Validator\PresenceOf;
                                use Phalcon\Validation\Validator\StringLength;
                                use Simpledom\Core\AtaForm;

                                class MelkPhoneListnerAreaForm extends AtaForm {

                                    public function initialize() {

                            
                            // ID
                            $id = new TextElement('id');
                            $id->setLabel('ID');
                            //$id->setAttribute('placeholder', 'Enter your ID');
                            $id->setAttribute('class', 'form-control');
                            $this->add($id);
                        

                            // Melk Phone Listner ID
                            $melkphonelistnerid = new TextElement('melkphonelistnerid');
                            $melkphonelistnerid->setLabel('Melk Phone Listner ID');
                            //$melkphonelistnerid->setAttribute('placeholder', 'Enter your Melk Phone Listner ID');
                            $melkphonelistnerid->setAttribute('class', 'form-control');$melkphonelistnerid->addValidator(new PresenceOf(array(
                       
                            )));$this->add($melkphonelistnerid);


                            // Area ID
                            $areaid = new TextElement('areaid');
                            $areaid->setLabel('Area ID');
                            //$areaid->setAttribute('placeholder', 'Enter your Area ID');
                            $areaid->setAttribute('class', 'form-control');$areaid->addValidator(new PresenceOf(array(
                       
                            )));$this->add($areaid);

                                        // Submit Button
                                        $submit = new Submit('submit');
                                        $submit->setName('submit');
                                        $submit->setAttribute('class', 'btn btn-primary');
                                        $this->add($submit);
                                    }

                                }


                          