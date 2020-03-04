<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Payment\Service\Request;

use Sakila\Command\Command;
use Sakila\Domain\Payment\Service\Request\UpdatePaymentRequest;
use Sakila\Test\AbstractUnitTestCase;

class UpdatePaymentRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $paymentId  = 1;
        $cut        = new UpdatePaymentRequest($paymentId, $attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($paymentId, $cut->getPaymentId());
    }
}
