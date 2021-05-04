<?php
require_once('functions/helper.php');

if (isset($_POST['edit_product'])) {
    if (!empty($_POST['category'])) {
        $product = new_product($_POST['name'], $_POST['description'], $_POST['price'], $_POST['kind'], $_POST['picture']);
        edit_product(clean($_POST['category']),  clean($_POST['product']), $product);
    }
    exit;
}

if (isset($_POST['delete_product'])) {
    if (!empty($_POST['category'])) {
        delete_product(clean($_POST['category']), clean($_POST['product']));
    }
    exit;
}

if (isset($_POST['add_product'])) {
    if (!empty($_POST['category'])) {
        $product = new_product($_POST['name'], $_POST['description'], $_POST['price'], $_POST['kind'], $_POST['picture']);
        add_product(clean($_POST['category']), $product);
    }
    exit;
}

if (isset($_POST['duplicate_product'])) {
    if (!empty($_POST['category'])) {
        duplicate_product(clean($_POST['category']), clean($_POST['product']));
    }
    exit;
}

if (isset($_POST['add_category'])) {
    add_category($_POST['category_name']);
    exit;
}

if (isset($_POST['edit_category'])) {
    edit_category($_POST['category_index'], $_POST['category_name']);
    exit;
}

if (isset($_POST['delete_category'])) {
    delete_category(clean($_POST['category']));
    exit;
}

if (isset($_POST['edit_company'])) {
    unset($_POST['edit_company']);
    edit_company($_POST);
    echo 'Saved';
    exit;
}

if (isset($_POST['get_form_url'])) {
    save_image('test',clean($_POST['url']));
    exit;
}

if (isset($_POST['imagefile'])) {
    // Getting file name
  $filename = $_FILES['imagefile']['name'];
 
  // Valid extension
  $valid_ext = array('png','jpeg','jpg');

  // Location
  $location = DOC_ROOT . 'img/products/'.$filename;

  // file extension
  $file_extension = pathinfo($location, PATHINFO_EXTENSION);
  $file_extension = strtolower($file_extension);

  // Check extension
  if(in_array($file_extension,$valid_ext)){

    // Compress Image
    compressImage($_FILES['imagefile']['tmp_name'],$location,60);

  }else{
    echo "Invalid file type.";
  }
}
