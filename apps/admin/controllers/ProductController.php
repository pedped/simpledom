<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use Category;
use ModelChart;
use Product;
use ProductForm;
use ProductFormImages;
use ProductFormVoice;
use ProductGallery;
use ProductSpecification;
use ProductSpecificationForm;
use Simpledom\Admin\BaseControllers\ControllerBase;
use Simpledom\Core\AtaForm;
use Simpledom\Core\Classes\Config;
use Simpledom\Core\Classes\FileManager;
use Simpledom\Core\Classes\Helper;

class ProductController extends ControllerBase {

    private $totalCount;

    public function initialize() {
        parent::initialize();
        $this->setTitle('محصولات');
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

        $fr = new ProductForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {

                // form is valid
                $product = new \Product();

                $product->title = $this->request->getPost('title', 'string');
                $product->categoryid = $this->request->getPost('categoryid', 'string');
                $product->timestamp = $this->request->getPost('timestamp', 'string');
                $product->description = $this->request->getPost('description', 'string');
                $product->voicepath = $this->request->getPost('voicepath', 'string');
                $product->brand = $this->request->getPost('brand', 'string');

                $product->price_purchase = $this->request->getPost('price_purchase', 'string');
                $product->price_sale = $this->request->getPost('price_sale', 'string');
                $product->price_discount = $this->request->getPost('price_discount', 'string');

                if ($this->request->has("barcode") && intval($this->request->get("barcode") > 0)) {
                    $product->barcode = $this->request->getPost('barcode', 'string');
                }

                $product->status = $this->request->getPost('status', 'string');
                $product->height = $this->request->getPost('height', 'string');
                $product->weight = $this->request->getPost('weight', 'string');
                $product->depth = $this->request->getPost('depth', 'string');

//                $product->flag_homepage = $this->request->getPost('showinhomepage', 'string');
//                $product->flag_offpage = $this->request->getPost('showinoffpage', 'string');
//                $product->flag_special = $this->request->getPost('showinfeaturelist', 'string');

                $product->brand = $this->request->getPost('brand', 'string');

                if (!$product->create()) {
                    $product->showErrorMessages($this);
                } else {

                    if ($this->request->hasFiles() && strlen($this->request->getUploadedFiles()[0]->getName()) > 0) {
                        // valid request, load the files
                        $file = $this->request->getUploadedFiles()[0];
                        $image = FileManager::HandleImageUpload($this->errors, $file, $outputname, $realtiveloaction);
                        if ($image) {
                            // unable to upload file
                            $image->link = $this->url->publicurl . "" . $realtiveloaction;
                            $image->save();

                            // create new Product Gallery Item
                            $product->AddImage($image);

                            // show success message
                            $this->flash->success("تصویر با موفقیت افزوده گردید");
                            
                           
                            
                        } else {
                            $this->flash->error("خطا در هنگام ارسال فایل");
                        }
                    }

                    $product->showSuccessMessages($this, 'محصول با موفقیت افزوده گردید');

                    // clear the title and message so the user can add better info
                    $fr->clear();
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }

        // load category lists
        $items = array();
        // load category lists
        $categories = Category::find(array("parentcategory IS NULL"));
        foreach ($categories as $category) {
            // add item to list
            $items[$category->id] = $category->title;
            self::LoadCategoris($category, $items, $category->title . " ----> ");
        }

        $fr->get("categoryid")->setOptions($items);

        $this->view->form = $fr;
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

    public function listAction($page = 1) {

        // load the users
        $products = Product::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $products,
            'limit' => 50,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'تصویر', 'نام', 'دسته', 'قیمت پایه', 'قیمت فروش', 'وضعیت',
                ))->
                setFields(array(
                    'id', 'getImageElement()', 'title', 'getCategoryName()', 'getBaseHumanPrice()', 'getSaleHumanPrice()', 'getStatusLabel()',
                ))->
                setEditUrl(
                        'product/edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'product/list');

        $this->view->list = $paginator->getPaginate();


        $this->view->totalProducts = Product::count();
        $this->view->existProducts = Product::count(array("status = :status:", "bind" => array("status" => PRODUCT_STATUS_ACTIVE)));
        $this->view->unavailableProducts = Product::count(array("status = :status:", "bind" => array("status" => PRODUCT_STATUS_OUTOFSTOCK)));
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = Product::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'product',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Product::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Product item');
            } else {
                $this->flash->success('Product item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'product',
                            'action' => 'list'
                ));
            }
        }
    }

    public function editAction($id, $tab = "statistics", $page = 1) {


        if (!$this->ValidateAccess($id)) {
            // user do not have permission to edut this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        switch ($tab) {
            case "statistics" :
                $this->viewTabStatistics($id);
                break;
            case "info" :
                $this->viewTabProductInfo($id);
                break;
            case "images" :
                $this->viewTabImagesInfo($id);
                break;
            case "voice" :
                $this->viewTabVoiceInfo($id);
                break;
            case "removeimage" :
                $this->viewTabRemoveImage($id, $page);
                break;
            case "removevoice" :
                $this->viewTabRemoveVoice($id);
                break;
            case "stock" :
                $this->viewTabStock($id);
                break;
            case "specification" :
                $this->viewTabSpecification($id);
                break;
            default :
                var_dump("invalid tab");
                die();
        }

        // set tab info
        $productItem = Product::findFirst($id);
        $this->view->tab = $tab;
        $this->view->product = $productItem;
    }

    public function viewTabProductInfo($id) {

        // set tab info
        $productItem = Product::findFirst($id);

        // create form
        $fr = new ProductForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $product = Product::findFirst($id);

                $product->title = $this->request->getPost('title', 'string');

                $product->categoryid = $this->request->getPost('categoryid', 'string');

                $product->timestamp = $this->request->getPost('timestamp', 'string');

                $product->description = $this->request->getPost('description', 'string');

                if ($this->request->has("barcode") && intval($this->request->get("barcode") > 0)) {
                    $product->barcode = $this->request->getPost('barcode', 'string');
                }
                $product->status = $this->request->getPost('status', 'string');

                $product->height = $this->request->getPost('height', 'string');

                $product->weight = $this->request->getPost('weight', 'string');

                $product->depth = $this->request->getPost('depth', 'string');

                $product->subtitle = $this->request->getPost('subtitle', 'string');

                $product->price_purchase = $this->request->getPost('price_purchase', 'string');

                $product->price_sale = $this->request->getPost('price_sale', 'string');

                $product->price_discount = $this->request->getPost('price_discount', 'string');


                $product->flag_homepage = $this->request->getPost('showinhomepage', 'string');
                $product->flag_offpage = $this->request->getPost('showinoffpage', 'string');
                $product->flag_special = $this->request->getPost('showinfeaturelist', 'string');

                $product->brand = $this->request->getPost('brand', 'string');

                if (!$product->save()) {
                    $product->showErrorMessages($this);
                } else {
                    $product->showSuccessMessages($this, 'اطلاعات محصول با موفقیت ذخیره گردید');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values
            $fr->get('title')->setDefault($productItem->title);
            // $fr->get('categoryid')->setDefault($productItem->categoryid);
            $fr->get('timestamp')->setDefault($productItem->timestamp);
            $fr->get('description')->setDefault($productItem->description);
            $fr->get('barcode')->setDefault($productItem->barcode);
            $fr->get('status')->setDefault($productItem->status);
            $fr->get('height')->setDefault($productItem->height);
            $fr->get('weight')->setDefault($productItem->weight);
            $fr->get('depth')->setDefault($productItem->depth);
            $fr->get('subtitle')->setDefault($productItem->subtitle);

            $fr->get('price_purchase')->setDefault($productItem->price_purchase);
            $fr->get('price_sale')->setDefault($productItem->price_sale);


            $fr->get('showinfeaturelist')->setDefault($productItem->flag_special);
            $fr->get('showinhomepage')->setDefault($productItem->flag_homepage);
            $fr->get('showinoffpage')->setDefault($productItem->flag_offpage);

            $fr->get('price_discount')->setDefault($productItem->price_discount);

            $fr->get('brand')->setDefault($productItem->brand);
        }


        // load category lists
        $items = array();
        // load category lists
        $categories = Category::find(array("parentcategory IS NULL"));
        foreach ($categories as $category) {
            // add item to list
            $items[$category->id] = $category->title;
            self::LoadCategoris($category, $items, $category->title . " ----> ");
        }

        $fr->get("categoryid")->setOptions($items);

        $this->view->form = $fr;
    }

    public function viewTabImagesInfo($id) {
        // set tab info
        $productItem = Product::findFirst($id);

        $fr = new ProductFormImages();
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

                        // create new Product Gallery Item
                        $productItem->AddImage($image);

                        // show success message
                        $this->flash->success("تصویر با موفقیت افزوده گردید");
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

        // find images
        $this->view->images = ProductGallery::find(array("product_id = :productid:", "bind" => array("productid" => $id)));

        $this->view->form = $fr;
    }

    public function viewTabRemoveImage($productid, $imageid) {
        // check if item exist
        $item = ProductGallery::findFirst($imageid);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'product',
                        'action' => 'edit',
                        "params" => array($productid)
            ));
        }



        // check if user want to remove it
        $result = ProductGallery::findFirst(array("id = :id: AND product_id = :product_id:", "bind" => array(
                        "id" => $imageid,
                        "product_id" => $productid,
            )))->delete();

        if (!$result) {
            $this->flash->error('خطایی در هنگام حذف تصویر رخ داد');
            Helper::RedirectToURL(Config::getPublicUrl() . "admin/product/edit/$productid/images");
        } else {
            $this->flash->success('تصویر با موفقیت حذف گردید');
            Helper::RedirectToURL(Config::getPublicUrl() . "admin/product/edit/$productid/images");
        }
    }

    public function viewTabVoiceInfo($id) {

        // set tab info
        $productItem = Product::findFirst($id);

        $fr = new ProductFormVoice();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                if ($this->request->hasFiles()) {
                    // valid request, load the files
                    $file = $this->request->getUploadedFiles()[0];
                    $uploadResult = FileManager::HandleProductVoiceUpload($this->errors, $file, $outputname, $realtiveloaction);
                    if ($uploadResult == TRUE) {
                        // unable to upload file
                        $url = $this->url->publicurl . "" . $realtiveloaction;

                        // voice path
                        $productItem->voicepath = $url;
                        if ($productItem->save()) {
                            // show success message
                            $this->flash->success("فایل صوتی محصول با موفقیت تغییر کرد");
                        } else {
                            $this->flash->error("خطا در هنگام ذخیره سازی فایل" . " : " . $productItem->getMessagesAsLines());
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


        $this->view->product = $productItem;

        $this->view->form = $fr;
    }

    public function viewTabRemoveVoice($productid) {
        $productItem = Product::findFirst($productid);
        $productItem->voicepath = null;
        $productItem->save();

        $this->flash->success("صدا با موفقیت حذف گردید");


        Helper::RedirectToURL(Config::getPublicUrl() . "admin/product/edit/$productid/voice");
    }

    public function viewTabStock($productid, $page = 1) {

        $productid = (int) $productid;

        $stockchanges = $this->modelsManager->createBuilder()
                ->from('StockChange')
                ->join('Stock')->where("Stock.productid = " . $productid)->andWhere("Stock.id = StockChange.stockid")
                ->orderBy('StockChange.stockid')
                ->limit(50, ($page - 1) * 50)
                ->getQuery()
                ->execute();


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $stockchanges,
            'limit' => 50,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'کد ورودی کالا', 'کد مشتری', 'کد کارگر', 'تعداد', 'تاریخ', 'دلیل', 'توضیحات'
                ))->
                setFields(array(
                    'id', 'stockid', 'userid', 'workerid', 'count', 'getDate()', 'getReasonCodeFlag()', 'reason'
                ))->setListPath(
                'product/edit/' . $productid . '/stock');

        $this->view->list = $paginator->getPaginate();
    }

    public function viewTabStatistics($productid) {

        $productItem = Product::findFirst($productid);
        $this->view->totalCount = $productItem->getRemainingCount();
        $this->view->ordersCount = $productItem->getOrdersCount();
        $this->view->problemsCount = $productItem->getProblemsCount();


        // load chart
        // create new form
        $form = new AtaForm();


        $stockchanges = $this->modelsManager->createBuilder()
                ->from('StockChange')
                ->join('Stock')->where("Stock.productid = " . $productid)->andWhere("Stock.id = StockChange.stockid")->andWhere("StockChange.reasoncode = 10")
                ->getQuery()
                ->execute();

        // load chart box
        // fetch data
        $modelChart = new ModelChart("orderchart", $stockchanges);
        $chartlement = $modelChart->getChart();
        $chartlement->setTitle("سفارشات");
        $chartlement->setSubtitle("تعداد سفارش در هر روز");
        $chartlement->setXName("تاریخ");
        $chartlement->setYAxis("تعداد");
        // add element to form
        $form->add($chartlement);

        // set view form
        $this->view->form = $form;
        $this->handleFormScripts($form);
    }

    public function viewTabSpecification($id, $page = 1) {




        $fr = new ProductSpecificationForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $productspecification = new \ProductSpecification();
                $productspecification->productid = $id;
                $productspecification->title = $this->request->getPost('title', 'string');
                $productspecification->value = $this->request->getPost('value', 'string');
                $productspecification->orderid = 0;
                $productspecification->create();

                $productspecification->showSuccessMessages($this, 'مشخصه جدید با موفقیت اضافه گردید');
                // clear the title and message so the user can add better info
                $fr->clear();
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }
        $this->view->form = $fr;










        // load the users
        $productspecifications = ProductSpecification::find(
                        array("productid = :productid:", "bind" => array("productid" => $id), 'order' => 'id DESC')
        );


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $productspecifications,
            'limit' => 1000,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'تیتر', 'مقدار'
                ))->
                setFields(array(
                    'title', 'value'
                ))->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'list');

        $this->view->list = $paginator->getPaginate();
    }

}
