<?php

namespace SimpleStore;

class Company
{
    private $company;
    public $name, $phone, $email, $header, $logo, $image_height, $image_size;
    private $data_path = DATA_ROOT . "company.json";

    function __construct()
    {
        global $lng;


        if (file_exists($this->data_path)) {
            $this->company = json_decode(file_get_contents($this->data_path));
        } else {
            $this->company = json_decode('{"name":"company name","phone":"","email":"","logo":"tile.png","header":"","image_height":"120","image_size":""cover}');
            if (!file_exists(DOC_ROOT . "data")) {
                mkdir(DOC_ROOT . "data", 0700);
            }
            file_put_contents($this->data_path, json_encode($this->company, JSON_UNESCAPED_UNICODE));
        }

        $name = "name_" . $lng;
        $header = "header_" . $lng;
        $this->name = isset($this->company->$name) ? $this->company->$name : $this->company->name;
        $this->phone = $this->company->phone;
        $this->email = $this->company->email;
        $this->logo = $this->company->logo;
        $this->header = isset($this->company->$header) ? $this->company->$header : $this->company->header;
        $this->image_height = $this->company->image_height;
        $this->image_size = $this->company->image_size;
    }

    function update($data)
    {
        global $lng;
        $exclude = ["phone", "email", "logo","image_height","image_size","edit_company"];
        foreach ($data as $key => $value) {
            if (in_array($key, $exclude)) {
                $this->company->$key = $value;
            } else {
                $key = $key . "_" . $lng;
                $this->company->$key = $value;
            }
        }
        file_put_contents($this->data_path, json_encode($this->company, JSON_UNESCAPED_UNICODE));
    }
}
