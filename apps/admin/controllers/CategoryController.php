<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use Category;
use CategoryForm;
use Simpledom\Admin\BaseControllers\ControllerBase;
use Simpledom\Core\Classes\FileManager;

class CategoryController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('دسته بندی ها');
    }

    /**
     * this function will validate request access
     * @param type $id
     * @return boolean
     */
    protected function ValidateAccess($id) {
        return true;
    }

    public function addAction() {

        $fr = new CategoryForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                if ($this->request->hasFiles()) {
                    // valid request, load the files
                    $file = $this->request->getUploadedFiles()[0];
                    $image = FileManager::HandleImageUpload($this->errors, $file, $outputname, $realtiveloaction);
                    if ($image) {
                        // unable to upload file
                        $image->link = $this->url->publicurl . "" . $realtiveloaction;
                        $image->save();

                        // form is valid
                        $category = new \Category();
                        if (strval($this->request->getPost('parentcategory', 'string')) == "0" || strlen($this->request->getPost('parentcategory', 'string')) == 0) {
                            // empty category
                            $category->parentcategory = null;
                        } else {
                            $category->parentcategory = $this->request->getPost('parentcategory', 'string');
                        }

                        $category->title = $this->request->getPost('title', 'string');
                        $category->imageid = $image->id;
                        $category->description = $this->request->getPost('description', 'string');
                        $category->active = $this->request->getPost('active', 'string');
                        if (!$category->create()) {
                            $category->showErrorMessages($this);
                        } else {
                            $category->showSuccessMessages($this, 'New Category added Successfully');

                            // clear the title and message so the user can add better info
                            $fr->clear();
                        }
                    } else {
                        $this->flash->error("خطا در هنگام ارسال فایل");
                    }
                } else {
                    $this->flash->error("فایل خود را انتخاب نکرده اید");
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }


        // load category lists
        $items = array();
        $items[""] = "-----";
        // load category lists
        $categories = Category::find(array("parentcategory IS NULL"));
        foreach ($categories as $category) {
            // add item to list
            $items[$category->id] = $category->title;
            self::LoadCategoris($category, $items, $category->title . " ----> ");
        }

        $fr->get("parentcategory")->setOptions($items);
        $this->view->form = $fr;
    }

    public function listAction($page = 1) {

        // load the users
        $categorys = Category::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $categorys,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'تصویر', 'تیتر', 'نام دسته پدر', 'تاریخ', 'وضعیت'
                ))->
                setFields(array(
                    'id', 'getImageElement()', 'title', 'getParentTitle()', 'getDate()', 'active'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'category/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = Category::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'category',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Category::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Category item');
            } else {
                $this->flash->success('Category item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'category',
                            'action' => 'list'
                ));
            }
        }
    }

    public function editAction($id) {


        if (!$this->ValidateAccess($id)) {
            // user do not have permission to edut this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // set title
        $this->setTitle('Edit Category');

        $categoryItem = Category::findFirst($id);

        // create form
        $fr = new CategoryForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $category = Category::findFirst($id);
                $category->parentcategory = $this->request->getPost('parentcategory', 'string');

                $category->title = $this->request->getPost('title', 'string');

                $category->imageid = $this->request->getPost('imageid', 'string');

                $category->description = $this->request->getPost('description', 'string');

                $category->date = $this->request->getPost('date', 'string');

                $category->active = $this->request->getPost('active', 'string');

                $category->delete = $this->request->getPost('delete', 'string');
                if (!$category->save()) {
                    $category->showErrorMessages($this);
                } else {
                    $category->showSuccessMessages($this, 'Category Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('parentcategory')->setDefault($categoryItem->parentcategory);
            $fr->get('title')->setDefault($categoryItem->title);
            $fr->get('imageid')->setDefault($categoryItem->imageid);
            $fr->get('description')->setDefault($categoryItem->description);
            $fr->get('date')->setDefault($categoryItem->date);
            $fr->get('active')->setDefault($categoryItem->active);
            $fr->get('delete')->setDefault($categoryItem->delete);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Category::findFirst($id);
        $this->view->item = $item;

        $form = new CategoryForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('parentcategory')->setDefault($item->parentcategory);
        $form->get('title')->setDefault($item->title);
        $form->get('imageid')->setDefault($item->imageid);
        $form->get('description')->setDefault($item->description);
        $form->get('date')->setDefault($item->date);
        $form->get('active')->setDefault($item->active);
        $form->get('delete')->setDefault($item->delete);
        $this->view->form = $form;
    }

    /**
     * 
     * @param Category $category
     * @param array $items
     */
    public static function LoadCategoris($category, &$items, $text) {
        // load sub categorus
        $subcat = Category::find(array("parentcategory = :parentcategory:", "bind" => array("parentcategory" => $category->id)));
        if (count($subcat) > 0) {
            foreach ($subcat as $item) {
                $items[$item->id] = $text . $item->title;
                // load inner categories
                self::LoadCategoris($item, $items, $text . $item->title . " ----> ");
            }
        }
    }

}