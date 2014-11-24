<?php

namespace Simpledom\Frontend\BaseControllers;

use Article;
use AtaPaginator;

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

    public function listAction($numberPage = 1) {
        // set page title
        $this->setPageTitle("آخرین مقالات");
        $this->setSubtitle("آخرین مقالات");

        // load the users
        $articles = Article::find(
                        array(
                            'order' => 'id DESC'
        ));


        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $articles,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID'
                ))->
                setFields(array(
                    'id'
                ))->setListPath(
                'question/lastest');

        $this->view->list = $paginator->getPaginate();
    }

    protected function ValidateAccess($id) {
        return true;
    }

}
