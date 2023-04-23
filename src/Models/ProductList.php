<?php

namespace Scandiweb\Models;

class ProductList
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
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
