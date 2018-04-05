<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Actor\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Actor\Commands\AddActorCommand;
use Sakila\Test\AbstractUnitTestCase;

class AddActorCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $cut        = new AddActorCommand($attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
