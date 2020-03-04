<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Address\Service\Request;

use Sakila\Command\Command;
use Sakila\Domain\Address\Service\Request\UpdateAddressRequest;
use Sakila\Test\AbstractUnitTestCase;

class UpdateAddressRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $addressId  = 1;
        $cut        = new UpdateAddressRequest($addressId, $attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($addressId, $cut->getAddressId());
    }
}
