<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Rental\Service\Request;

use Sakila\Command\CommandInterface;
use Sakila\Domain\Rental\Service\Request\UpdateRentalRequest;
use Sakila\Test\AbstractUnitTestCase;

class UpdateRentalRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $rentalId   = 1;
        $cut        = new UpdateRentalRequest($rentalId, $attributes);

        $this->assertInstanceOf(CommandInterface::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($rentalId, $cut->getRentalId());
    }
}
