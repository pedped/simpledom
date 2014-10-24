<?php

                                 namespace Simpledom\Core;
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

                                class SMSCreditCostForm extends AtaForm {

                                    public function initialize() {

                            
                            // ID
                            $id = new TextElement('id');
                            $id->setLabel('ID');
                            //$id->setAttribute('placeholder', 'Enter your ID');
                            $id->setAttribute('class', 'form-control');
                            $this->add($id);
                        

                            // Title
                            $title = new TextElement('title');
                            $title->setLabel('Title');
                            //$title->setAttribute('placeholder', 'Enter your Title');
                            $title->setAttribute('class', 'form-control');$title->addValidator(new PresenceOf(array(
                       
                            )));$this->add($title);


                            // Description
                            $description = new TextElement('description');
                            $description->setLabel('Description');
                            //$description->setAttribute('placeholder', 'Enter your Description');
                            $description->setAttribute('class', 'form-control');$description->addValidator(new PresenceOf(array(
                       
                            )));$this->add($description);


                            // Total SMS Can Send
                            $totalsms = new TextElement('totalsms');
                            $totalsms->setLabel('Total SMS Can Send');
                            //$totalsms->setAttribute('placeholder', 'Enter your Total SMS Can Send');
                            $totalsms->setAttribute('class', 'form-control');$totalsms->addValidator(new PresenceOf(array(
                       
                            )));$this->add($totalsms);


                            // Price
                            $price = new TextElement('price');
                            $price->setLabel('Price');
                            //$price->setAttribute('placeholder', 'Enter your Price');
                            $price->setAttribute('class', 'form-control');$price->addValidator(new PresenceOf(array(
                       
                            )));$this->add($price);


                            // Date
                            $date = new TextElement('date');
                            $date->setLabel('Date');
                            //$date->setAttribute('placeholder', 'Enter your Date');
                            $date->setAttribute('class', 'form-control');$this->add($date);

                                        // Submit Button
                                        $submit = new Submit('submit');
                                        $submit->setName('submit');
                                        $submit->setAttribute('class', 'btn btn-primary');
                                        $this->add($submit);
                                    }

                                }


                          