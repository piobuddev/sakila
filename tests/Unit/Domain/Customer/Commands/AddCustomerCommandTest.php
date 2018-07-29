<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Customer\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Customer\Commands\AddCustomerCommand;
use Sakila\Test\AbstractUnitTestCase;

class AddCustomerCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $cut        = new AddCustomerCommand($attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
