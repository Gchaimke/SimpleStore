<?php

namespace SimpleStore;

class Category
{
    public $id, $name, $last_index;

    function __construct($name="New Category")
    {
        $this->id = 1;
        $this->name = $name;
        $this->last_index = 1;
    }

    function get($categories, $id)
    {
        foreach ($categories as $category) {
            if ($category->id == $id) {
                return $category;
            }
        }
        return null;
    }
}
