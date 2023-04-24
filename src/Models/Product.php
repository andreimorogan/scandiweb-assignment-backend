<?php

namespace Scandiweb\Models;

use Scandiweb\Config\Database;

abstract class Product
{
    public $data;
    public $db;
    public $errors = [];

    public function __construct()
    {
        $request = file_get_contents('php://input');
        $this->data = json_decode($request);
        $this->db = new Database();
        $this->db->connect();
    }

    public function trimRequest()
    {
        foreach ((array)$this->data as &$value) {
            if (is_string($value)) {
                $value = trim($value);
            }
        }
    }

    public function validateSku()
    {
        if (!isset($this->data->sku) || $this->data->sku === '') {
            array_push($this->errors, "Please provide a valid SKU.");
        }

        if (strlen($this->data->sku) > 50) {
            array_push($this->errors, "Maximum SKU character limit is 50.");
        }

        $dbCheck = $this->db->prepare('SELECT sku FROM products WHERE sku = :sku');
        $dbCheck->bindParam(':sku', $this->data->sku);
        $dbCheck->execute();

        if ($dbCheck->rowCount() > 0) {
            array_push($this->errors, "SKU already exists.");
        }

        return "Valid sku.";
    }


    public function validateName()
    {
        if (!isset($this->data->name) || $this->data->name === '') {
            array_push($this->errors, "Please provide a valid name.");
        }

        if (strlen($this->data->name) > 255) {
            array_push($this->errors, "Maximum name character limit is 255.");
        }

        return "Valid name";
    }

    public function validatePrice()
    {
        if (!isset($this->data->price) || $this->data->price === '') {
            array_push($this->errors, "Please provide a valid price.");
        }
        $pattern = '/^\d{1,5}(\.\d{1,2})?$/';
        if (!preg_match($pattern, $this->data->price)) {
            array_push(
                $this->errors,
                "Price can only have up to 7 digits, with two decimals separated by a full stop."
            );
        }

        return "Valid price";
    }

    abstract protected function validateTypeProperty();

    abstract protected function validateTypeValue();
}
