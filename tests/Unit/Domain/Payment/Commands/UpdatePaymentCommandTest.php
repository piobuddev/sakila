<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Payment\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Payment\Commands\UpdatePaymentCommand;
use Sakila\Test\AbstractUnitTestCase;

class UpdatePaymentCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $paymentId  = 1;
        $cut        = new UpdatePaymentCommand($paymentId, $attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($paymentId, $cut->getPaymentId());
    }
}
