<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Address\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Address\Commands\UpdateAddressCommand;
use Sakila\Test\AbstractUnitTestCase;

class UpdateAddressCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $addressId  = 1;
        $cut        = new UpdateAddressCommand($addressId, $attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($addressId, $cut->getAddressId());
    }
}
