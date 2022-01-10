<?php
namespace SimpleStore;

//Load Composer's autoloaderW
require_once(__DIR__ . '/../vendor/autoload.php');

require_once(DOC_ROOT . 'Classes/Helper.php');
require_once(DOC_ROOT . 'Classes/Company.php');
require_once(DOC_ROOT . 'Classes/Category.php');
require_once(DOC_ROOT . 'Classes/Product.php');
require_once(DOC_ROOT . 'Classes/Cart.php');
require_once(DOC_ROOT . 'Classes/Email.php');

class Store
{
    public $carrency, $company, $category, $product, $cart, $email;

    function __construct()
    {
        if (!file_exists(DATA_ROOT)) {
            mkdir(DATA_ROOT, 0700);
        }
        if (!file_exists(DATA_ROOT . "orders")) {
            mkdir(DATA_ROOT . "orders", 0700);
        }
        $this->company = new Company;
        $this->carrency = $this->company->currency;
        $this->price_format = $this->company->price_format;
        $this->category = new Category;
        $this->product = new Product;
        $this->cart = new Cart;
        $this->email = new Email;
    }

}
