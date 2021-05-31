<?php
class Company
{
    private $company;
    public $name, $phone, $email, $header, $logo;

    function __construct()
    {
        global $lng;

        $path = DOC_ROOT . "data/company.json";
        if (file_exists($path)) {
            $this->company = json_decode(file_get_contents($path));
        } else {
            $this->company = json_decode("{}");
        }

        $name = "name_" . $lng;
        $header = "header_" . $lng;
        $this->name = $this->company->$name;
        $this->phone = $this->company->phone;
        $this->email = $this->company->email;
        $this->logo = $this->company->logo;
        $this->header = $this->company->$header;
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
