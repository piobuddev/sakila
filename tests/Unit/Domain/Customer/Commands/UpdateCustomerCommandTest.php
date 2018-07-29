<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Customer\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Customer\Commands\UpdateCustomerCommand;
use Sakila\Test\AbstractUnitTestCase;

class UpdateCustomerCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $customerId = 1;
        $cut        = new UpdateCustomerCommand($customerId, $attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($customerId, $cut->getCustomerId());
    }
}
