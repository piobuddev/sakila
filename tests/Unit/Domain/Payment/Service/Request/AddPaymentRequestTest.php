<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Payment\Service\Request;

use Sakila\Command\Command;
use Sakila\Domain\Payment\Service\Request\AddPaymentRequest;
use Sakila\Test\AbstractUnitTestCase;

class AddPaymentRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $cut        = new AddPaymentRequest($attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
