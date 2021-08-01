<?php

namespace SimpleStore;

class Categories
{
    public $categories;
    public $data_path = DATA_ROOT;

    function get_categories()
    {
        if (file_exists($this->data_path . "categories.json")) {
            $this->categories = json_decode(file_get_contents($this->data_path . "categories.json"));
        } else {
            $this->categories = json_decode('[{"id":"1","name":"category 1"}]');
            if (!file_exists(DOC_ROOT . "data")) {
                mkdir(DOC_ROOT . "data", 0700);
            }
            file_put_contents($this->data_path . "categories.json", json_encode($this->categories, JSON_UNESCAPED_UNICODE));
            $product = new Product();
            $product->id = 1;
            $products[] = $product;
            file_put_contents($this->data_path . "1.json", json_encode($products, JSON_UNESCAPED_UNICODE));
            $product->id = "1_1";
            $favorites[] = $product;
            file_put_contents($this->data_path . "favorites.json", json_encode($products, JSON_UNESCAPED_UNICODE));
            copy(DOC_ROOT."distrikts_template.json",$this->data_path."distrikts.json");
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

    function get_category($index)
    {
        $categories = $this->get_categories();
        foreach ($categories as $category) {
            if($category->id == $index){
                return $category;
            }
        }
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
