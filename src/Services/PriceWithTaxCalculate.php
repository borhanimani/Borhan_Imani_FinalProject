<?php

namespace App\Services;

class PriceWithTaxCalculate
{

    private $taxType = null;

    public function __construct(ProductTaxType $taxType)
    {
        $this->taxType = $taxType;
    }

    function calculatePriceWithTax($price,$productType)
    {
        return ($price * (1 + $this->taxType->getProductType($productType)));
    }
}