<?php

namespace App\Util\CurrencyConverter;

use App\Model\Product;

class ProductCurrencyConverterUtil
{
    /**
     * @param Product $product
     * @param float $exchangeRate
     * @return Product
     */
    public function convert(Product $product, float $exchangeRate): Product
    {
        $product->setPrice(
            $exchangeRate * $product->getPrice()
        );

        return $product;
    }
}