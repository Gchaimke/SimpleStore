<?php
namespace SimpleStore;

require_once(DOC_ROOT . 'Classes/Company.php');
require_once(DOC_ROOT . 'Classes/Categories.php');
require_once(DOC_ROOT . 'Classes/Category.php');
require_once(DOC_ROOT . 'Classes/Products.php');
require_once(DOC_ROOT . 'Classes/Product.php');

class Store
{
    public $carrency, $company, $categories,$products;

    function __construct()
    {
        if (!file_exists(DOC_ROOT . "data")) {
            mkdir(DOC_ROOT . "data", 0700);
        }
        if (!file_exists(DOC_ROOT . "data/orders")) {
            mkdir(DOC_ROOT . "data/orders", 0700);
        }
        $this->carrency = "₪";
        $this->company = new Company;
        $this->categories = new Categories;
        $this->products = new Products;
    }

}
