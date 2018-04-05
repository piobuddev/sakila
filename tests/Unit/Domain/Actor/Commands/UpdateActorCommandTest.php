<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Actor\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Actor\Commands\UpdateActorCommand;
use Sakila\Test\AbstractUnitTestCase;

class UpdateActorCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $actorId    = 1;
        $cut        = new UpdateActorCommand($actorId, $attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($actorId, $cut->getActorId());
    }
}
