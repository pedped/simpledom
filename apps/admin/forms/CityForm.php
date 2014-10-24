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

                                class CityForm extends AtaForm {

                                    public function initialize() {

                            
                            // ID
                            $id = new TextElement('id');
                            $id->setLabel('ID');
                            //$id->setAttribute('placeholder', 'Enter your ID');
                            $id->setAttribute('class', 'form-control');
                            $this->add($id);
                        

                            // State ID
                            $stateid = new TextElement('stateid');
                            $stateid->setLabel('State ID');
                            //$stateid->setAttribute('placeholder', 'Enter your State ID');
                            $stateid->setAttribute('class', 'form-control');$stateid->addValidator(new PresenceOf(array(
                       
                            )));$this->add($stateid);


                            // Name
                            $name = new TextElement('name');
                            $name->setLabel('Name');
                            //$name->setAttribute('placeholder', 'Enter your Name');
                            $name->setAttribute('class', 'form-control');$name->addValidator(new PresenceOf(array(
                       
                            )));$this->add($name);

                                        // Submit Button
                                        $submit = new Submit('submit');
                                        $submit->setName('submit');
                                        $submit->setAttribute('class', 'btn btn-primary');
                                        $this->add($submit);
                                    }

                                }


                          