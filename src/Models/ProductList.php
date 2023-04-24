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
    private $request;


    public function __construct($db)
    {
        $this->db = $db;
        $this->validationClasses = [
            "Size" => new DVD(),
            "Weight" => new Book(),
            "Dimensions" => new Furniture()
        ];
        $this->request = file_get_contents('php://input');
        $this->request = json_decode($request);
    }

    public function validateInput()
    {
        $request = file_get_contents('php://input');
        $requestData = json_decode($request);

        $propertyType = $requestData->typeProperty;
        $propertyValue = $requestData->typeValue;
        $validator = $this->validationClasses[$propertyType] ?? null;
        if (!$validator) {
            $errors = ["Invalid property type."];
            return $errors;
        }

        $validator->data = $requestData;
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
        $request = file_get_contents('php://input');
        $data = json_decode($request);
        $statement = $this->db->prepare(
            'INSERT INTO products (sku, name, price, property_type, property_value) 
            VALUES (:sku, :name, :price, :property_type, :property_value)'
        );

        $statement->bindParam(':sku', $data->sku);
        $statement->bindParam(':name', $data->name);
        $statement->bindParam(':price', $data->price);
        $statement->bindParam(':property_type', $data->typeProperty);
        $statement->bindParam(':property_value', $data->typeValue);
        $statement->execute();

        return "Product created successfully";
    }

    public function deleteProduct()
    {
        $request = file_get_contents('php://input');
        $data = json_decode($request);
        $statement = $this->db->prepare(
            'DELETE FROM products
            WHERE sku=:sku'
        );

        foreach ($data as $sku) {
            $statement->bindParam(':sku', $sku);
            $statement->execute();
        }

        return "Products deleted successfully";
    }
}
