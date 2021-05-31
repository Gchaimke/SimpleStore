<?php
class Product
{
    public $id, $name, $description, $price, $kind, $img;

    function __construct()
    {
        $this->id = 1;
        $this->name = "new product";
        $this->description = '';
        $this->price = 50;
        $this->qtty = '1';
        $this->kind = 'kg';
        $this->img = 'img/product.jpg';
    }

    function update($data)
    {
        global $lng;
        $exclude = ["phone", "email", "logo"];
        foreach ($data as $key => $value) {
            if (in_array($key, $exclude)) {
                $this->company->$key = $value;
            } else {
                $key = $key . "_" . $lng;
                $this->company->$key = $value;
            }
        }
        file_put_contents(DOC_ROOT . "data/company.json", json_encode($this->company, JSON_UNESCAPED_UNICODE));
    }
}
