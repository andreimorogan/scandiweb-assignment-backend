<?php

namespace Scandiweb\Controllers;

use Scandiweb\Models\ProductList;
use Scandiweb\Config\Database;

class ProductController
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->db->connect();
    }

    public function create()
    {
        $productList = new ProductList($this->db);
        $data = $productList->createProduct();
        return $data;
    }

    public function read()
    {
        $productList = new ProductList($this->db);
        $data = $productList->getAllProducts();
        return $data;
    }

    public function delete()
    {
        $productList = new ProductList($this->db);
        $data = $productList->deleteProduct();
        return $data;
    }
}
