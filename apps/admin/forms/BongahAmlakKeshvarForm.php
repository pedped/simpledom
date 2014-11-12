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

                                class BongahAmlakKeshvarForm extends AtaForm {

                                    public function initialize() {

                            
                            // ID
                            $id = new TextElement('id');
                            $id->setLabel('ID');
                            //$id->setAttribute('placeholder', 'Enter your ID');
                            $id->setAttribute('class', 'form-control');
                            $this->add($id);
                        

                            // State
                            $state = new TextElement('state');
                            $state->setLabel('State');
                            //$state->setAttribute('placeholder', 'Enter your State');
                            $state->setAttribute('class', 'form-control');$state->addValidator(new PresenceOf(array(
                       
                            )));$this->add($state);


                            // City
                            $city = new TextElement('city');
                            $city->setLabel('City');
                            //$city->setAttribute('placeholder', 'Enter your City');
                            $city->setAttribute('class', 'form-control');$city->addValidator(new PresenceOf(array(
                       
                            )));$this->add($city);


                            // Name
                            $name = new TextElement('name');
                            $name->setLabel('Name');
                            //$name->setAttribute('placeholder', 'Enter your Name');
                            $name->setAttribute('class', 'form-control');$name->addValidator(new PresenceOf(array(
                       
                            )));$this->add($name);


                            // Code
                            $code = new TextElement('code');
                            $code->setLabel('Code');
                            //$code->setAttribute('placeholder', 'Enter your Code');
                            $code->setAttribute('class', 'form-control');$code->addValidator(new PresenceOf(array(
                       
                            )));$this->add($code);


                            // Phone
                            $phone = new TextElement('phone');
                            $phone->setLabel('Phone');
                            //$phone->setAttribute('placeholder', 'Enter your Phone');
                            $phone->setAttribute('class', 'form-control');$phone->addValidator(new PresenceOf(array(
                       
                            )));$this->add($phone);


                            // Mobile
                            $mobile = new TextElement('mobile');
                            $mobile->setLabel('Mobile');
                            //$mobile->setAttribute('placeholder', 'Enter your Mobile');
                            $mobile->setAttribute('class', 'form-control');$mobile->addValidator(new PresenceOf(array(
                       
                            )));$this->add($mobile);


                            // Address
                            $address = new TextElement('address');
                            $address->setLabel('Address');
                            //$address->setAttribute('placeholder', 'Enter your Address');
                            $address->setAttribute('class', 'form-control');$address->addValidator(new PresenceOf(array(
                       
                            )));$this->add($address);


                            // City ID
                            $cityid = new TextElement('cityid');
                            $cityid->setLabel('City ID');
                            //$cityid->setAttribute('placeholder', 'Enter your City ID');
                            $cityid->setAttribute('class', 'form-control');$cityid->addValidator(new PresenceOf(array(
                       
                            )));$this->add($cityid);


                            // State ID
                            $stateid = new TextElement('stateid');
                            $stateid->setLabel('State ID');
                            //$stateid->setAttribute('placeholder', 'Enter your State ID');
                            $stateid->setAttribute('class', 'form-control');$stateid->addValidator(new PresenceOf(array(
                       
                            )));$this->add($stateid);

                                        // Submit Button
                                        $submit = new Submit('submit');
                                        $submit->setName('submit');
                                        $submit->setAttribute('class', 'btn btn-primary');
                                        $this->add($submit);
                                    }

                                }


                          