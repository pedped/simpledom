<?php

namespace Simpledom\Frontend\BaseControllers;

use Page;

class PageControllerBase extends ControllerBase {

    public function viewAction($id = 1) {
        $page = Page::findFirst($id);
        if (!$page) {
            $this->show404();
            return;
        }

        // set view and title
        $this->setPageTitle($page->title);
        $this->view->agreement = $page;

        // check if the page has meta keywords and meta description
        if (strlen($page->metakey) > 0) {
            $this->setMetaKeywords($page->metakey);
        }
        if (strlen($page->metadata) > 0) {
            $this->setMetaKeywords($page->metadata);
        }
    }

}
