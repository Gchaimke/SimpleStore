<?php

namespace SimpleStore;

class Categories
{
    public $categories;
    public $data_path = DOC_ROOT . "data/";

    function get_categories()
    {
        if (file_exists($this->data_path)) {
            $this->categories = json_decode(file_get_contents($this->data_path . "categories.json"));
        } else {
            $this->categories = json_decode("{}");
        }
        return $this->categories;
    }

    function get_last_id()
    {
        $bigest_id = 0;
        foreach ($this->categories as $category) {
            if ($bigest_id < $category->id) {
                $bigest_id = $category->id;
            }
        }
        return $bigest_id;
    }

    function get_categories_with_products()
    {
        global $lng;
        $categories = $this->get_categories();
        foreach ($categories as &$category) {
            $name = "name_" . $lng;
            $category->name = property_exists($category, $name) ? $category->$name : $category->name;
            $category->products = json_decode(file_get_contents($this->data_path . $category->id . ".json"));
        }
        return $categories;
    }

    function add_category($name = 'New Category')
    {
        global $lng;
        $name_key = "name_" . $lng;

        $categories = $this->get_categories();
        $last_category_id =  $this->get_last_id();
        $category = new Category($name);
        $category->id = $last_category_id + 1;
        $category->$name_key = $name;
        $categories[] = $category;
        $product = new Product();
        $product->id = 1;
        $products[] = $product;
        file_put_contents($this->data_path . "categories.json", json_encode($categories, JSON_UNESCAPED_UNICODE));
        file_put_contents($this->data_path . "$category->id.json", json_encode($products, JSON_UNESCAPED_UNICODE));
    }

    function edit_category($id, $key, $value)
    {
        $categories = $this->get_categories();
        foreach ($categories as &$category) {
            if ($category->id == $id) {
                $category->$key = $value;
            }
        }
        file_put_contents($this->data_path . "categories.json", json_encode($categories, JSON_UNESCAPED_UNICODE));
    }
}
