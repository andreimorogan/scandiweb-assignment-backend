<?php

namespace Scandiweb\Models;

use Scandiweb\Models\Product;
use Scandiweb\Models\Subclasses\Furniture;
use Scandiweb\Models\Subclasses\DVD;
use Scandiweb\Models\Subclasses\Book;

class ProductList
{
    private $db;
    private array $validationClasses;
    private $requestData;


    public function __construct($db)
    {
        $this->db = $db;
        $this->validationClasses = [
            "Size" => new DVD(),
            "Weight" => new Book(),
            "Dimensions" => new Furniture()
        ];
        $request = file_get_contents('php://input');
        $this->requestData = json_decode($request);
    }

    public function validateInput()
    {
        $propertyType = $this->requestData->typeProperty;
        $propertyValue = $this->requestData->typeValue;
        $validator = $this->validationClasses[$propertyType] ?? null;
        if (!$validator) {
            $errors = ["Invalid property type."];
            return $errors;
        }

        $validator->data = $this->requestData;
        $validator->trimRequest();
        $validator->validateTypeProperty();
        $validator->validateSku();
        $validator->validateName();
        $validator->validatePrice();
        $validator->validateTypeValue();
        return $validator->errors;
    }


    public function getAllProducts()
    {
        $products = $this->db->query('SELECT * FROM products ORDER BY product_id ASC');
        return $products;
    }

    public function createProduct()
    {
        $validationErrors = $this->validateInput();
        if (!empty($validationErrors)) {
            return $validationErrors;
        }

        $statement = $this->db->prepare(
            'INSERT INTO products (sku, name, price, property_type, property_value) 
            VALUES (:sku, :name, :price, :property_type, :property_value)'
        );

        $statement->bindParam(':sku', $this->requestData->sku);
        $statement->bindParam(':name', $this->requestData->name);
        $statement->bindParam(':price', $this->requestData->price);
        $statement->bindParam(':property_type', $this->requestData->typeProperty);
        $statement->bindParam(':property_value', $this->requestData->typeValue);
        $statement->execute();

        return "Product created successfully";
    }

    public function deleteProduct()
    {
        $statement = $this->db->prepare(
            'DELETE FROM products
            WHERE sku=:sku'
        );

        foreach ($this->requestData as $sku) {
            trim($sku);
            $statement->bindParam(':sku', $sku);
            $statement->execute();
        }

        return "Products deleted successfully";
    }
}
