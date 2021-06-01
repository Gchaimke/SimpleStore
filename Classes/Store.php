<?php
namespace SimpleStore;

require_once(DOC_ROOT . 'Classes/Company.php');
require_once(DOC_ROOT . 'Classes/Categories.php');
require_once(DOC_ROOT . 'Classes/Product.php');

class Store
{
    public $carrency, $company, $categories, $price, $kind, $img;

    function __construct()
    {
        $this->carrency = "₪";
        $this->company = new Company;
        $this->categories = new Categories;
    }
}
