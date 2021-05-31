<?php
class Categories
{
    public $categories;

    function __construct()
    {
        global $lng;

        $path = DOC_ROOT . "data/";
        if (file_exists($path)) {
            $this->categories = json_decode(file_get_contents($path . "categories.json"));
        } else {
            $this->categories = json_decode("{}");
        }

        foreach ($this->categories as &$category) {
            $name = "name_" . $lng;
            $category->name = $category->$name;
            $category->products = json_decode(file_get_contents($path . $category->id . ".json"));;
        }
    }

    function update($data)
    {
        global $lng;
        $exclude = ["id", "last_index"];
        foreach ($data as $key => $value) {
            if (in_array($key, $exclude)) {
                $this->company->$key = $value;
            } else {
                $key = $key . "_" . $lng;
                $this->company->$key = $value;
            }
        }
        file_put_contents(DOC_ROOT . "data/categories.json", json_encode($this->categories, JSON_UNESCAPED_UNICODE));
    }

    function get_category($id)
    {
        foreach ($this->categories as $category) {
            if ($category->id == $id) {
                if (!property_exists($category, 'last_index')) {
                    $category->last_index = 1;
                }
                return $category;
            }
        }
        return null;
    }

    function add_category($name = 'New Category')
    {
        $last_category =  end($this->categories);
        $category = new stdClass();
        $category->id = isset($last_category->id) ? $last_category->id + 1 : 1;
        $category->name = $name;
        $category->last_index = 1;
        $categories[] = $category;
        $product = new Product();
        $product->id = 1;
        $products[] = $product;
        file_put_contents(DOC_ROOT . "data/categories.json", json_encode($this->categories, JSON_UNESCAPED_UNICODE));
        file_put_contents(DOC_ROOT . "data/$category->id.json", json_encode($products, JSON_UNESCAPED_UNICODE));
    }
}
