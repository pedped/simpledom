<?php

use Simpledom\Core\AtaForm;

class MelkInfoViewForm extends AtaForm {

    public function initialize() {
        // MAP
        $map = new MapElement('map');
        $map->setName('map');
        $map->setAttribute('class', 'form-control');
        $this->add($map);
    }

}
