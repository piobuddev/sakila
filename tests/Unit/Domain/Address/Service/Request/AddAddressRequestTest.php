<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Address\Service\Request;

use Sakila\Command\CommandInterface;
use Sakila\Domain\Address\Service\Request\AddAddressRequest;
use Sakila\Test\AbstractUnitTestCase;

class AddAddressRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $cut        = new AddAddressRequest($attributes);

        $this->assertInstanceOf(CommandInterface::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
