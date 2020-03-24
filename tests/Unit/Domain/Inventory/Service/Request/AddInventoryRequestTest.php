<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Inventory\Service\Request;

use Sakila\Command\CommandInterface;
use Sakila\Domain\Inventory\Service\Request\AddInventoryRequest;
use Sakila\Test\AbstractUnitTestCase;

class AddInventoryRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $cut        = new AddInventoryRequest($attributes);

        $this->assertInstanceOf(CommandInterface::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
