<?php

use Phalcon\Paginator\Adapter\Model as Paginator;
use Simpledom\Core\Classes\Config;

class AtaPaginator extends Paginator {

    private $searchItemArrays = array();
    private $orderItemArrays = array();
    private $listPath;
    private $editUrl;
    private $deleteUrl;
    private $tableHeaders = array();
    private $fields = array();

    public function getViewUrl() {
        return $this->editUrl;
    }

    public function getDeleteUrl() {
        return $this->deleteUrl;
    }

    /**
     * 
     * @param type $viewUrl
     * @return AtaPaginator
     */
    public function setEditUrl($viewUrl) {
        $this->editUrl = $viewUrl;
        return $this;
    }

    /**
     * 
     * @param type $deleteUrl
     * @return AtaPaginator
     */
    public function setDeleteUrl($deleteUrl) {
        $this->deleteUrl = $deleteUrl;
        return $this;
    }

    public function getTableHeaders() {
        return $this->tableHeaders;
    }

    public function getFields() {
        return $this->fields;
    }

    /**
     * 
     * @param type $tableHeaders
     * @return AtaPaginator
     */
    public function setTableHeaders($tableHeaders) {
        $this->tableHeaders = $tableHeaders;
        return $this;
    }

    /**
     * 
     * @param type $fields
     * @return AtaPaginator
     */
    public function setFields($fields) {
        $this->fields = $fields;
        return $this;
    }

    public function getListPath($pageNumber = 1) {

        global $di;
        $baseUrl = $di->getUrl()->getBaseUri();

        // parse url
        $baseUrl = strlen(isset(parse_url($baseUrl)["scheme"]) ? parse_url($baseUrl)["scheme"] : "") > 0 ? $baseUrl : Config::getPublicUrl() . substr($baseUrl, 1);

        // load default path
        $list = $this->listPath;

        // check if we have page number
        $hasPageNumberInPath = false;
        if (strpos($list, "{pn}") != FALSE) {
            $hasPageNumberInPath = true;
        }

        // replace path number with that
        if ($hasPageNumberInPath) {
            $list = $baseUrl . str_replace("{pn}", $pageNumber, $list);
        } else {
            // do not have any number
            return $baseUrl . $list . "/" . $pageNumber;
        }

        return $list;
    }

    /**
     * 
     * @param type $listPath
     * @return AtaPaginator
     */
    public function setListPath($listPath) {
        $this->listPath = $listPath;
        return $this;
    }

    /**
     * 
     * @return Array
     */
    public function getSearchItemArrays() {
        return $this->searchItemArrays;
    }

    /**
     * 
     * @return Array
     */
    public function getOrderItemArrays() {
        return $this->orderItemArrays;
    }

    /**
     * 
     * @param Array $searchItemArrays
     */
    public function setSearchItemArrays($searchItemArrays) {
        $this->searchItemArrays = $searchItemArrays;
    }

    /**
     * 
     * @param Array $orderItemArrays
     */
    public function setOrderItemArrays($orderItemArrays) {
        $this->orderItemArrays = $orderItemArrays;
    }

    /**
     * Return Paginator
     * @return type
     */
    public function getPaginate() {
        $paginate = parent::getPaginate();
        $paginate->header = $this->getHeader();
        $paginate->table = $this->getTable($paginate);
        $paginate->footer = $this->getFooter($paginate);
        return $paginate;
    }

    /**
     * Create Simple Header for items
     * @param type $enableSearch
     * @param type $enableOrder
     */
    public function getHeader($enableSearch = true, $enableOrder = true) {

        // check if we have search box
        if (is_array($this->searchItemArrays) && count($this->searchItemArrays) == 0) {
            return "";
        }


        $result = "
            
            <form method='post' class='paginator-header form-inline'>
                ";
        // we have to check if we have any search array, add that
        if (is_array($this->searchItemArrays) && count($this->searchItemArrays) > 0) {
            // there are some option to add
            $result.= "";
            $result.= "<div class='row'><div class='col-md-4' style='padding-top: 5px;padding-left: 25px;'>Search In &nbsp&nbsp</div><div class='col-md-2'></div><div class='col-md-6' style='text-align: right;'><select class='form-control' name='target'>";
            foreach ($this->getSearchItemArrays() as $key => $value) {
                $result.="<option value='$key'>$value</option>";
            }
            $result.="</select>";
            $result .= "
                <div class='input-group'>
                    <input class='form-control' type='text' name='searchquery' placeholder='" . _("Search Text Goes Here...") . "' />
                    <span class='input-group-btn'>
                      <input type='submit' value='Search' class='btn btn-primary'>" . _("Search") . "</button>
                    </span>
                </div>
            </div>";
        }
        $result.=" </div>
            </form>
            ";
        return $result;
    }

    /**
     * return the footer of the page
     * @param type $paginate
     * @return type
     */
    public function getFooter($paginate) {

        return "
            <!-- Pagination Items !-->
            <div class='center'>
                <div class='pagination pagination-centered'>
                    <li> <a class='pag' href='" . $this->getListPath() . "'>" . _("First") . "</a></li>
                    <li> <a href='" . $this->getListPath($paginate->before) . "'>" . _("Previous") . "</a></li>
                    <li> <a href='" . $this->getListPath($paginate->next) . "'>" . _("Next") . "</a></li>
                    <li> <a href='" . $this->getListPath($paginate->last) . "'>" . _("Last") . "</a></li>
                </div>
                <div>
                 " . sprintf(_("You are in page %s of %s"), $paginate->current, $paginate->total_pages) . "  
                </div>
            </div>";
    }

    public function getTable($paginate) {
        $result = "";

        // add table head
        $result .= "
            <div class='table-responsive'>
            <table class='table table-bordered table-striped table-condensed mb-none '>
                <thead>
                    <tr>";

        // add each fileds
        foreach ($this->getTableHeaders() as $value) {
            $result .= "<th>$value</th>";
        }

        // add action box
        if (isset($this->editUrl) && strlen($this->editUrl) > 0 && isset($this->deleteUrl) && strlen($this->deleteUrl) > 0) {
            $result .= "<th>" . _("Action") . "</th>";
        }
        // close the table fields
        $result .= "</tr>";
        $result .= "</thead>";


        // add each item
        $i = 0;
        foreach ($paginate->items as $item) {
            $result .= "<tr>";
            foreach ($this->getFields() as $key => $value) {

                // check if we have to show function or property
                if (strpos($value, "(") == 0) {
                    // it is field
                    $text = $item->$value;
                    $result .= "<td>$text</td>";
                } else {
                    // it is function
                    $s = strpos($value, "(");
                    $text = call_user_func(array($item, substr($value, 0, $s)));
                    if (is_bool($text)) {
                        if ((boolval($text))) {
                            $result .= "<td>" . _("Yes") . "</td>";
                        } else {
                            $result .= "<td>" . _("No") . "</td>";
                        }
                    } else {
                        $result .= "<td>$text</td>";
                    }
                }
            }
            // add action bar
            if (isset($this->editUrl) && strlen($this->editUrl) > 0 && isset($this->deleteUrl) && strlen($this->deleteUrl) > 0) {
                $result .= "
                <td>";
                if (isset($this->editUrl)) {
                    $result .= "<a href='$this->editUrl/$item->id' class='on-default edit-row'><i class='fa fa-pencil' title='" . _("View/Edit") . "'></i></a>";
                }
                if (isset($this->deleteUrl)) {
                    $result .= "&nbsp;<a href='$this->deleteUrl/$item->id' class='on-default remove-row'><i class='fa fa-trash-o' title='" . _("Delete") . "'></i></a>";
                }
                $result .= "</td>";
            }
            $result .= "</tr>";
            $i++;
        }

        // close the table
        $result .= "</table>
        </div>";

        // return the result
        return $result;
    }
}
