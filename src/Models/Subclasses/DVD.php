<?php

namespace Scandiweb\Models\Subclasses;

use Scandiweb\Models\Product;

class DVD extends Product
{
    public function __construct(string $sku, string $name, string $priceInput, string $typeValue)
    {
        parent::__construct($sku, $name, $priceInput);
        $this->typeProperty = 'Size';
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
}
