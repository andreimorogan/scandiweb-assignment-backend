<?php

namespace Scandiweb\Models\Subclasses;

use Scandiweb\Models\Product;

class Furniture extends Product
{
    public function validateTypeProperty()
    {
        if ($this->data->typeProperty !== 'Dimensions') {
            array_push($this->errors, "Invalid product type.");
        }
        return "Valid property type";
    }

    public function validateTypeValue()
    {
        $typeValue = $this->data->typeValue;

        if (!preg_match('/^(\d{1,4}(\.\d{1,2})?x){2}\d{1,4}(\.\d{1,2})?$/', $typeValue)) {
            array_push(
                $this->errors,
                "Dimensions are limited to numbers of 3000 each, with a max of two decimals."
            );
        }

        return "Valid dimensions.";
    }
}
