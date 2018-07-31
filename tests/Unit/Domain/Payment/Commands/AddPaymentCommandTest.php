<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Payment\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Payment\Commands\AddPaymentCommand;
use Sakila\Test\AbstractUnitTestCase;

class AddPaymentCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $cut        = new AddPaymentCommand($attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
