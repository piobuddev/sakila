<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Store\Service\Request;

use Sakila\Command\CommandInterface;
use Sakila\Domain\Store\Service\Request\AddStoreRequest;
use Sakila\Test\AbstractUnitTestCase;

class AddStoreRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $cut        = new AddStoreRequest($attributes);

        $this->assertInstanceOf(CommandInterface::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
