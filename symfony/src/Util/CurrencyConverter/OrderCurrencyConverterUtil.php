<?php

namespace App\Util\CurrencyConverter;

use App\Model\Order;

class OrderCurrencyConverterUtil
{
    /**
     * @var ProductCurrencyConverterUtil
     */
    private $productCurrencyConverterUtil;

    /**
     * @param ProductCurrencyConverterUtil $productCurrencyConverterUtil
     */
    public function __construct(ProductCurrencyConverterUtil $productCurrencyConverterUtil)
    {
        $this->productCurrencyConverterUtil = $productCurrencyConverterUtil;
    }

    /**
     * @param Order $order
     * @param float $exchangeRate
     * @param $newCurrency
     * @return Order
     */
    public function convert(Order $order, float $exchangeRate, $newCurrency): Order
    {
        $order->setTotal(
            $exchangeRate * $order->getTotal()
        )
        ->setCurrency($newCurrency);

        foreach ($order->getProducts() as $product) {
            $this->productCurrencyConverterUtil->convert($product, $exchangeRate);
        }

        return $order;
    }
}