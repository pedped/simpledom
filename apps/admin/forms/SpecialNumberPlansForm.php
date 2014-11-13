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

                                class SpecialNumberPlansForm extends AtaForm {

                                    public function initialize() {

                            
                            // ID
                            $id = new TextElement('id');
                            $id->setLabel('ID');
                            //$id->setAttribute('placeholder', 'Enter your ID');
                            $id->setAttribute('class', 'form-control');
                            $this->add($id);
                        

                            // Name
                            $name = new TextElement('name');
                            $name->setLabel('Name');
                            //$name->setAttribute('placeholder', 'Enter your Name');
                            $name->setAttribute('class', 'form-control');$name->addValidator(new PresenceOf(array(
                       
                            )));$this->add($name);


                            // Length
                            $length = new TextElement('length');
                            $length->setLabel('Length');
                            //$length->setAttribute('placeholder', 'Enter your Length');
                            $length->setAttribute('class', 'form-control');$length->addValidator(new PresenceOf(array(
                       
                            )));$this->add($length);


                            // Pre Code
                            $precode = new TextElement('precode');
                            $precode->setLabel('Pre Code');
                            //$precode->setAttribute('placeholder', 'Enter your Pre Code');
                            $precode->setAttribute('class', 'form-control');$precode->addValidator(new PresenceOf(array(
                       
                            )));$this->add($precode);


                            // Price
                            $price = new TextElement('price');
                            $price->setLabel('Price');
                            //$price->setAttribute('placeholder', 'Enter your Price');
                            $price->setAttribute('class', 'form-control');$price->addValidator(new PresenceOf(array(
                       
                            )));$this->add($price);


                            // Enable
                            $enable = new EnableDisableElement('enable');
                            $enable->setLabel('Enable');
                            //$enable->setAttribute('placeholder', 'Enter your Enable');
                            $enable->setAttribute('class', 'form-control');$enable->addValidator(new PresenceOf(array(
                       
                            )));$this->add($enable);

                                        // Submit Button
                                        $submit = new Submit('submit');
                                        $submit->setName('submit');
                                        $submit->setAttribute('class', 'btn btn-primary');
                                        $this->add($submit);
                                    }

                                }


                          