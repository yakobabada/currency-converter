<?php

namespace App\Command;

use App\Model\Order;
use App\Model\Orders;
use App\Util\CurrencyConverter\OrderCurrencyConverterUtil;
use App\Util\ExchangeRateUtil;
use App\Util\SerializerUtil;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class ConvertCurrencyCommand extends Command
{
    /**
     * @var SerializerUtil
     */
    private $serializerUtil;

    /**
     * @var ExchangeRateUtil
     */
    private $exchangeRateUtil;
    /**
     * @var OrderCurrencyConverterUtil
     */
    private $orderCurrencyConverterUtil;

    /**
     * ConvertCurrencyCommand constructor.
     * @param SerializerUtil $serializerUtil
     * @param ExchangeRateUtil $exchangeRateUtil
     * @param OrderCurrencyConverterUtil $orderCurrencyConverterUtil
     */
    public function __construct(
        SerializerUtil $serializerUtil,
        ExchangeRateUtil $exchangeRateUtil,
        OrderCurrencyConverterUtil $orderCurrencyConverterUtil
    ) {
        parent::__construct();
        $this->serializerUtil = $serializerUtil;
        $this->exchangeRateUtil = $exchangeRateUtil;
        $this->orderCurrencyConverterUtil = $orderCurrencyConverterUtil;
    }

    protected function configure()
    {
        $this
            ->setName('app:convert-currency-for-orders')
            ->setDescription('Convert currency for orders.')
            ->addArgument(
                'id-currency',
                InputArgument::IS_ARRAY | InputArgument::OPTIONAL,
                'Pass id currency list Ex: 1=EUR'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Convert currency',
            '============',
            '',
        ]);

        $idCurrencyList = [];

        foreach ($input->getArgument('id-currency') as $idCurrency) {
            $idCurrencyElements = explode('=', $idCurrency);
            $idCurrencyList[$idCurrencyElements[0]] = $idCurrencyElements[1];
        }

        $finder = new Finder();
        $finder->files()->in('data/source');
        $finder->name('Orders.xml');

        $fileSystem = new Filesystem();

        foreach ($finder as $file) {
            $orders = new Orders();
            $orders = $this->serializerUtil->deserialize($file->getContents(), $orders);

            /** @var Order $order */
            foreach ($orders->getOrderList() as $order) {
                if (!key_exists($order->getId(), $idCurrencyList)) {
                    continue;
                }

                $exchangeRate = $this->exchangeRateUtil->get($order->getCurrency(), $idCurrencyList[$order->getId()]);
                $this->orderCurrencyConverterUtil->convert($order, $exchangeRate, $idCurrencyList[$order->getId()]);
            }

            $fileSystem->dumpFile(
                'data/destination/ExchangeRates.xml',
                $this->serializerUtil->serialize($orders, 'xml')
            );
        }

        $output->writeln('Done successfully!');
    }
}