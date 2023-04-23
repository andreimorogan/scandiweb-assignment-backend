<?php

namespace Scandiweb\Models;

abstract class Product
{
    protected string $sku;
    protected string $name;
    protected float $price;
    protected string $typeProperty;
    protected string $typeValue;

    public function __construct(string $sku, string $name, float $price)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    abstract public function getTypeProperty(): string;

    abstract public function getTypeValue(): string;
}
