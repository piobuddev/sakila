<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Inventory\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Inventory\Commands\AddInventoryCommand;
use Sakila\Test\AbstractUnitTestCase;

class AddInventoryCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $cut        = new AddInventoryCommand($attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
