<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Store\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Store\Commands\UpdateStoreCommand;
use Sakila\Test\AbstractUnitTestCase;

class UpdateStoreCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $storeId    = 1;
        $cut        = new UpdateStoreCommand($storeId, $attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($storeId, $cut->getStoreId());
    }
}
