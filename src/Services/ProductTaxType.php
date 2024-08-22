<?php

namespace App\Services;

class ProductTaxType
{
    const PRODUCT_TYPE = ['Laptop' => 0.10];

    function getProductType($type)
    {
        if (array_key_exists($type, self::PRODUCT_TYPE)) {
            return self::PRODUCT_TYPE[$type];
        }else{
            throw new \Exception("product type not found");
        }
    }
}