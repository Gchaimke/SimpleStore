<?php
class Categories
{
    public $categories;

    function __construct()
    {
        global $lng;

        $path = DOC_ROOT . "data/categories.json";
        if (file_exists($path)) {
            $this->categories = json_decode(file_get_contents($path));
        } else {
            $this->categories = json_decode("{}");
        }

        foreach ($this->categories as &$category) {
            $name = "name_" . $lng;
            $category->name = $category->$name;
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
        file_put_contents(DOC_ROOT . "data/categories.json", json_encode($this->company, JSON_UNESCAPED_UNICODE));
    }
}
