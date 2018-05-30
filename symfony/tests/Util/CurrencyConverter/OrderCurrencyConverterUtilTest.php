<?php

namespace App\Tests\Util\CurrencyConverter;

use App\Model\Order;
use App\Model\Product;
use App\Util\CurrencyConverter\ProductCurrencyConverterUtil;
use App\Util\CurrencyConverter\OrderCurrencyConverterUtil;
use PHPUnit\Framework\TestCase;

class OrderCurrencyConverterUtilTest extends TestCase
{
    /**
     * @var ProductCurrencyConverterUtil
     */
    private $productCurrencyConverterUtil;

    public function setUp()
    {
        parent::setUp();

        $this->productCurrencyConverterUtil = $this->createMock(ProductCurrencyConverterUtil::class);

        $this->productCurrencyConverterUtil->expects($this->any())
            ->method('convert')
            ->willReturn((new Product())
                ->setTitle('test-product')
                ->setPrice(117.1507));
    }

    public function testConvertReturnOrder()
    {
        $order = (new Order())
            ->setCurrency('EUR')
            ->setTotal(144);

        $orderCurrencyChangeUtil = new OrderCurrencyConverterUtil($this->productCurrencyConverterUtil);
        $result = $orderCurrencyChangeUtil->convert($order, 1.171507, 'USD');

        $this->assertInstanceOf(Order::class, $result);
    }

    public function testConvert()
    {
        $order = (new Order())
            ->setCurrency('EUR')
            ->setTotal(144);

        $orderCurrencyChangeUtil = new OrderCurrencyConverterUtil($this->productCurrencyConverterUtil);
        $order = $orderCurrencyChangeUtil->convert($order, 1.171507, 'USD');

        $this->assertEquals(168.697008, $order->getTotal());
    }

//    public function testConvertProducts()
//    {
//        $order = (new Order())
//            ->setCurrency('EUR')
//            ->setTotal(144)
//            ->addProduct(
//                (new Product())
//                    ->setTitle('test-product')
//                    ->setPrice(100)
//            );
//
//        $orderCurrencyChangeUtil = new OrderCurrencyConverterUtil($this->productCurrencyConverterUtil);
//        $order = $orderCurrencyChangeUtil->convert($order, 1.171507, 'USD');
//
//        $this->assertEquals(100, $order->getProducts()->first()->getPrice());
//    }
}