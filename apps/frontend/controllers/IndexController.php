<?php

namespace Simpledom\Frontend\Controllers;

use MoshaverType;
use Simpledom\Frontend\BaseControllers\IndexControllerBase;

class IndexController extends IndexControllerBase {

    public function indexAction() {

        // load the moshaver types
        $this->view->moshaverTypes = MoshaverType::find();

        // set page title
        $this->setPageTitle("خانه");
        
        // set subtitle
        $this->setSubtitle("تخصصی ترین مرجع مشاوره آنلاین");
    }

}
