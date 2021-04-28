<?php

function get_categories()
{
    return json_decode(file_get_contents('data/categories.json'));
}

function get_products($file = 0)
{
    return json_decode(file_get_contents("data/$file.json"));
}

function save_json($categories, $file_name = 'test')
{
    file_put_contents("data/$file_name.json", $categories);
}
