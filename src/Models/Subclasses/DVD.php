<?php

namespace Scandiweb\Models\Subclasses;

use Scandiweb\Models\Product;

class DVD extends Product
{
    public function validateTypeProperty()
    {
        if ($this->data->typeProperty !== 'Size') {
            array_push($this->errors, "Invalid product type.");
        }
        return "Valid property type";
    }

    public function validateTypeValue()
    {
        $typeValue = $this->data->typeValue;

        if (!is_numeric($typeValue)) {
            array_push($this->errors, "Size must be a number.");
        }

        if (!isset($this->data->typeValue) || $this->data->typeValue === '') {
            array_push($this->errors, "Please provide a valid size.");
        }

        if ($typeValue > 10000) {
            array_push($this->errors, "size value cannot be greater than 10000.");
        }

        return "Valid size.";
    }
}
