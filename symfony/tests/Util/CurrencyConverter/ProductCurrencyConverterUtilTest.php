<?php

namespace App\Tests\Util\CurrencyConverter;

use App\Model\Product;
use App\Util\CurrencyConverter\ProductCurrencyConverterUtil;
use PHPUnit\Framework\TestCase;

class ProductCurrencyConverterUtilTest extends TestCase
{
    public function testConvertReturnOrder()
    {
        $product = (new Product())
            ->setTitle('test-product')
            ->setPrice(100);

        $orderCurrencyChangeUtil = new ProductCurrencyConverterUtil();
        $result = $orderCurrencyChangeUtil->convert($product, 1.171507);

        $this->assertInstanceOf(Product::class, $result);
    }

    public function testConvert()
    {
        $product = (new Product())
            ->setTitle('test-product')
            ->setPrice(100);

        $orderCurrencyChangeUtil = new ProductCurrencyConverterUtil();
        $product = $orderCurrencyChangeUtil->convert($product, 1.171507);

        $this->assertEquals(117.1507, $product->getPrice());
    }
}