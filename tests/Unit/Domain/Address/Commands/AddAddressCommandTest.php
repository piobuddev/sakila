<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Address\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Address\Commands\AddAddressCommand;
use Sakila\Test\AbstractUnitTestCase;

class AddAddressCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $cut        = new AddAddressCommand($attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
