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
        $this->carrency = "₪";
        $this->company = new Company;
        $this->categories = new Categories;
        $this->products = new Products;
    }

}
