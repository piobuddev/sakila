<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Store\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Store\Commands\AddStoreCommand;
use Sakila\Test\AbstractUnitTestCase;

class AddStoreCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $cut        = new AddStoreCommand($attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
