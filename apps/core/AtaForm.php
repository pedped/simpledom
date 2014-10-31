<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Form;
use Simpledom\Frontend\Controllers\ControllerBase;

class AtaForm extends Form {

    public function initialize() {

        //Add a text element to put a hidden csrf
        $this->add(new Hidden("csrf"));
    }

    /**
     * This method returns the default value for field 'csrf'
     */
    public function getCsrf() {
        return $this->security->getToken();
    }

    public function renderDecorated($name, $width = "auto", $height = "auto") {
        $element = $this->get($name);


        //Get any generated messages for the current element
        $messages = $this->getMessagesFor($element->getName());

        $elementName = "";
        if (defined("DEBUG_MODE")) {
            $elementName = '<span class="bold red">( ' . $element->getName() . ' )</span>';
        }

        echo '<div class="elementholder" id="', $element->getName(), '_holder">';
        $elementLable = $element->getLabel();
        if (isset($elementLable) && strlen($elementLable) > 0) {
            echo '<label class="elementlabel" for="', $element->getName(), '">', $element->getLabel(), $elementName, '</label>';
        } else if (defined("DEBUG_MODE")) {
            echo '<label class="elementlabel" for="', $element->getName(), '">', $elementName, '</label>';
        }


        // check if we need to add element info
        try {
            if (method_exists($element, "getInfo")) {
                $elementInfo = $element->getInfo();
                if (isset($elementInfo) && strlen($elementInfo) > 0) {
                    echo '<p class="elementinfo">', $elementInfo, '</p>';
                }
            }
        } catch (Exception $exc) {
            
        }

        echo '<div style="width:' . $width . ';height:' . $height . '">';
        echo $element;

        // check if we need to add element info
        try {
            if (method_exists($element, "getFooter")) {
                $elementFooter = $element->getFooter();
                if (isset($elementFooter) && strlen($elementFooter) > 0) {
                    echo '<p class="elementfooter">', $elementFooter, '</p>';
                }
            }
        } catch (Exception $exc) {
            
        }
        echo '</div>';
        if (count($messages)) {
            //Print each element
            echo '<div class="element-error-messages">';
            foreach ($messages as $message) {
                echo ($message) . "<br/>";
            }
            echo '</div>';
        }
        echo '</div>';
    }

    public function renderInfo($name) {
        $element = $this->get($name);

        echo '<div class="form-group">
                <label for="' . $element->getName() . '" class="col-sm-2 control-label">' . $element->getLabel() . '</label>
                <div class="col-sm-10">
                  ' . $element->getDefault() . '
                </div>
              </div>';
    }

    /**
     * flash error message to controller
     * @param ControllerBase $controller
     * @param type $this
     */
    public function flashErrors(&$controller) {
        foreach ($this->getMessages() as $message) {
            $controller->flash->error($message);
        }
    }

}
