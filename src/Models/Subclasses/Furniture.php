<?php

namespace Scandiweb\Models\Subclasses;

use Scandiweb\Models\Product;

class Furniture extends Product
{
    public function __construct(string $sku, string $name, string $priceInput, string $typeValue)
    {
        parent::__construct($sku, $name, $priceInput);
        $this->typeProperty = 'Dimensions';
        $this->typeValue = $typeValue;
    }

    public function getTypeProperty(): string
    {
        return $this->typeProperty;
    }

    public function getTypeValue(): string
    {
        return $this->typeValue;
    }

    public function test()
    {
        echo "Success";
    }
}
