<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Inventory\Service\Request;

use Sakila\Command\Command;
use Sakila\Domain\Inventory\Service\Request\UpdateInventoryRequest;
use Sakila\Test\AbstractUnitTestCase;

class UpdateInventoryRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes  = ['foo' => 'bar'];
        $inventoryId = 1;
        $cut         = new UpdateInventoryRequest($inventoryId, $attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($inventoryId, $cut->getInventoryId());
    }
}
