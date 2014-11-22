<?php

namespace Simpledom\Frontend\BaseControllers;

use Article;

class ArticleControllerBase extends ControllerBase {

    public function viewAction($id = 1) {
        $article = Article::findFirst($id);
        if (!$article) {
            $this->show404();
            return;
        }

        // set view and title
        $this->setPageTitle($article->title);
        $this->view->article = $article;
    }

    protected function ValidateAccess($id) {
        return true;
    }

}
