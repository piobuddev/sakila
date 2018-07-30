<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Inventory\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Inventory\Commands\UpdateInventoryCommand;
use Sakila\Test\AbstractUnitTestCase;

class UpdateInventoryCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes  = ['foo' => 'bar'];
        $inventoryId = 1;
        $cut         = new UpdateInventoryCommand($inventoryId, $attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($inventoryId, $cut->getInventoryId());
    }
}
