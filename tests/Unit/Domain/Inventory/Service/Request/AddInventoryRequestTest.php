<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Inventory\Service\Request;

use Sakila\Command\Command;
use Sakila\Domain\Inventory\Service\Request\AddInventoryRequest;
use Sakila\Test\AbstractUnitTestCase;

class AddInventoryRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $cut        = new AddInventoryRequest($attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
