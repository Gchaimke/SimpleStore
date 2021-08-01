<?php
namespace SimpleStore;
require_once(DOC_ROOT . 'Classes/Helper.php');
require_once(DOC_ROOT . 'Classes/Company.php');
require_once(DOC_ROOT . 'Classes/Categories.php');
require_once(DOC_ROOT . 'Classes/Category.php');
require_once(DOC_ROOT . 'Classes/Products.php');
require_once(DOC_ROOT . 'Classes/Product.php');
require_once(DOC_ROOT . 'Classes/Cart.php');

class Store
{
    public $carrency, $company, $categories, $products, $cart;

    function __construct()
    {
        if (!file_exists(DATA_ROOT)) {
            mkdir(DATA_ROOT, 0700);
        }
        if (!file_exists(DATA_ROOT . "orders")) {
            mkdir(DATA_ROOT . "orders", 0700);
        }
        $this->carrency = "₪";
        $this->company = new Company;
        $this->categories = new Categories;
        $this->products = new Products;
        $this->cart = new Cart;
    }

}
