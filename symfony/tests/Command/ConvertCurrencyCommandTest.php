<?php

namespace App\Tests\Command;

use App\Command\ConvertCurrencyCommand;
use App\Model\Orders;
use App\Util\CurrencyConverter\OrderCurrencyConverterUtil;
use App\Util\ExchangeRateUtil;
use App\Util\SerializerUtil;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ConvertCurrencyCommandTest extends KernelTestCase
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

    public function setUp()
    {
        parent::setUp();

        $this->serializerUtil = $this->createMock(SerializerUtil::class);
        $this->exchangeRateUtil = $this->createMock(ExchangeRateUtil::class);
        $this->orderCurrencyConverterUtil = $this->createMock(OrderCurrencyConverterUtil::class);

        $this->serializerUtil->expects($this->any())
            ->method('deserialize')
            ->willReturn(new Orders());
    }

    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $application->add(new ConvertCurrencyCommand(
            $this->serializerUtil,
            $this->exchangeRateUtil,
            $this->orderCurrencyConverterUtil
        ));

        $command = $application->find('app:convert-currency-for-orders');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
        'command'  => $command->getName(),
        'id-currency' =>  ['1=EUR', '2=GPB'],
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('Convert currency', $output);
    }
}