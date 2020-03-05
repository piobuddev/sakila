<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Actor\Service\Request;

use Sakila\Command\Command;
use Sakila\Domain\Actor\Service\Request\RemoveActorRequest;
use Sakila\Test\AbstractUnitTestCase;

class RemoveActorRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $actorId = 1;
        $cut = new RemoveActorRequest(1);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($actorId, $cut->getActorId());
    }
}
