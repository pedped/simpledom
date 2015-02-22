<?php

namespace Simpledom\Api\Controllers;

use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;
use Product;
use ProductImage;
use Simpledom\Core\Classes\FileManager;
use stdClass;

class ProductController extends ControllerBase {

    public function addAction() {

        // start database transaction
        $transactionManager = new TransactionManager();
        $transaction = $transactionManager->get();

        // check if product uuid is not exist in server
        if (Product::count(array("uuid = :uuid:", "bind" => array("uuid" => $this->request->getPost("uuid")))) > 0) {
            $this->errors[] = "این محصول قبلا ارسال شده است";
        }

        // check if we have any error
        if (!$this->hasError()) {


            try {





                // create product info
                $product = new Product();
                $product->setTransaction($transaction);
                $product->title = $this->request->getPost("title");
                $product->barcodenumber = $this->request->getPost("barcode");
                $product->categoryid = $this->request->getPost("categoryid");
                $product->color = $this->request->getPost("color");
                $product->country_who_made = $this->request->getPost("madeby");
                $product->description = $this->request->getPost("description");
                $product->min_request_count = $this->request->getPost("minrequest");
                $product->offlineadd = $this->request->getPost("offlineadd");
                $product->order_request_instruction = $this->request->getPost("requestinstruction");
                $product->price = $this->request->getPost("price");
                $product->currency = $this->request->getPost("currency");
                $product->sale_price = $this->request->getPost("saleprice");
                $product->send_point = $this->request->getPost("sendpoint");
                $product->userid = $this->user->userid;
                $product->uuid = $this->request->getPost("uuid");
                if (!$product->create()) {
                    $transaction->rollback($product->getMessagesAsLines());
                }

                // save images
                if (!$this->hasError() && $this->request->hasFiles()) {
                    // valid request, load the files
                    foreach ($this->request->getUploadedFiles() as $file) {
                        $image = FileManager::HandleImageUpload($this->errors, $file, $outputname, $realtiveloaction);
                        if ($image) {
                            $productImage = new ProductImage();
                            $productImage->setTransaction($transaction);
                            $productImage->imageid = $image->id;
                            $productImage->product_id = $product->id;
                            if (!$productImage->create()) {
                                $transaction->rollback($productImage->getMessagesAsLines());
                            }
                        }
                    }
                }

                // succcessfull, we have to commit transaction and store
                //  information
                $transaction->commit();

                // send success result
                $item = new stdClass();
                $item->productid = $product->id;
                $item->productinfo = $product->getPublicResponse();

                // return info
                return $this->getResponse($item);
            } catch (Failed $e) {
                $this->errors[] = $e->getMessage();
            }
        }

        // unsuccess
        return $this->getResponse(false);
    }

    public function findbybarcodeAction($barcodeNumber) {

        // find user products
        $start = (int) $_POST["start"];
        $limit = (int) $_POST["limit"];

        $products = Product::find(
                        array(
                            "barcodenumber = :barcode: AND status = 1",
                            "bind" =>
                            array("barcode" => $barcodeNumber)
                        )
        );

        // send products
        $results = array();
        foreach ($products as $product) {
            $results[] = $product->getPublicResponse();
        }
        return $this->getResponse($results);
    }

    public function findbyproducttitleAction($title) {


        // trim title
        $title = trim($title);

        // check if we have text query
        if (strlen($title) == 0) {
            // we have to send null
            return $this->getResponse(array());
        }


        // find user products
        $start = (int) $_POST["start"];
        $limit = (int) $_POST["limit"];

        $products = Product::find(
                        array(
                            "title LIKE CONCAT('%' , :title: , '%' ) AND status = 1",
                            "bind" =>
                            array("title" => $title)
                        )
        );

        // send products
        $results = array();
        foreach ($products as $product) {
            $results[] = $product->getPublicResponse();
        }
        return $this->getResponse($results);
    }

}
