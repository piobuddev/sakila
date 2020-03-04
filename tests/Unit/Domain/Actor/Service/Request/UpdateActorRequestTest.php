<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Actor\Service\Request;

use Sakila\Command\Command;
use Sakila\Domain\Actor\Service\Request\UpdateActorRequest;
use Sakila\Test\AbstractUnitTestCase;

class UpdateActorRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['firstName' => 'Joe', 'lastName' => 'Doe'];
        $actorId    = 1;
        $cut        = new UpdateActorRequest($actorId, $attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($actorId, $cut->getActorId());
    }
}
