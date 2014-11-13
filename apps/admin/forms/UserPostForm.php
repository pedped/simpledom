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

                                class UserPostForm extends AtaForm {

                                    public function initialize() {

                            
                            // ID
                            $id = new TextElement('id');
                            $id->setLabel('ID');
                            //$id->setAttribute('placeholder', 'Enter your ID');
                            $id->setAttribute('class', 'form-control');
                            $this->add($id);
                        

                            // User ID
                            $userid = new TextElement('userid');
                            $userid->setLabel('User ID');
                            //$userid->setAttribute('placeholder', 'Enter your User ID');
                            $userid->setAttribute('class', 'form-control');$userid->addValidator(new PresenceOf(array(
                       
                            )));$this->add($userid);


                            // Post ID
                            $postid = new TextElement('postid');
                            $postid->setLabel('Post ID');
                            //$postid->setAttribute('placeholder', 'Enter your Post ID');
                            $postid->setAttribute('class', 'form-control');$postid->addValidator(new PresenceOf(array(
                       
                            )));$this->add($postid);


                            // Code
                            $code = new TextElement('code');
                            $code->setLabel('Code');
                            //$code->setAttribute('placeholder', 'Enter your Code');
                            $code->setAttribute('class', 'form-control');$this->add($code);

                                        // Submit Button
                                        $submit = new Submit('submit');
                                        $submit->setName('submit');
                                        $submit->setAttribute('class', 'btn btn-primary');
                                        $this->add($submit);
                                    }

                                }


                          