<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Payment\Service\Request;

use Sakila\Command\CommandInterface;
use Sakila\Domain\Payment\Service\Request\AddPaymentRequest;
use Sakila\Test\AbstractUnitTestCase;

class AddPaymentRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $cut        = new AddPaymentRequest($attributes);

        $this->assertInstanceOf(CommandInterface::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
