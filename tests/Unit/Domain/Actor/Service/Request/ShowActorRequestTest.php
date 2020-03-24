<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Actor\Service\Request;

use Sakila\Command\CommandInterface;
use Sakila\Domain\Actor\Service\Request\ShowActorRequest;
use Sakila\Test\AbstractUnitTestCase;

class ShowActorRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $actorId = 1;
        $cut = new ShowActorRequest(1);

        $this->assertInstanceOf(CommandInterface::class, $cut);
        $this->assertEquals($actorId, $cut->getActorId());
    }
}
