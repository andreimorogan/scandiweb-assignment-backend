<?php

namespace Scandiweb\Models\Subclasses;

use Scandiweb\Models\Product;

class Book extends Product
{
    public function validateTypeProperty()
    {
        if ($this->data->typeProperty !== 'Weight') {
            array_push($this->errors, "Invalid product type.");
        }
        return "Valid property.";
    }

    public function validateTypeValue()
    {
        $typeValue = $this->data->typeValue;

        if (!is_numeric($typeValue)) {
            array_push($this->errors, "Weight must be a number.");
        }

        if (!isset($this->data->typeValue) || $this->data->typeValue === '') {
            array_push($this->errors, "Please provide a valid weight.");
        }

        if ($typeValue > 100) {
            array_push($this->errors, "Weight value cannot be greater than 100.");
        }

        return $this->errors;
    }
}
