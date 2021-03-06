<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Actor\Service\Request;

use Sakila\Command\CommandInterface;
use Sakila\Domain\Actor\Service\Request\AddActorRequest;
use Sakila\Test\AbstractUnitTestCase;

class AddActorRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['firstName' => 'Joe', 'lastName' => 'Doe'];
        $cut        = new AddActorRequest($attributes);

        $this->assertInstanceOf(CommandInterface::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
