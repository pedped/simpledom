<?php

namespace Simpledom\Frontend\Controllers;

use Article;
use MoshaverType;
use Question;
use Simpledom\Frontend\BaseControllers\IndexControllerBase;

class IndexController extends IndexControllerBase {

    public function indexAction() {

        // load the moshaver types
        $this->view->moshaverTypes = MoshaverType::find("enable=1");

        // set page title
        $this->setPageTitle("خانه");

        // set subtitle
        $this->setSubtitle("تخصصی ترین مرجع مشاوره آنلاین");

        // set last articles
        $this->view->lastArticles = Article::find(array(
                    "order" => "id DESC",
                    "limit" => "5",
        ));

        // set last questions
        $this->view->lastQuestion = Question::find(array(
                    "order" => "id DESC",
                    "limit" => "5",
        ));
    }

}
