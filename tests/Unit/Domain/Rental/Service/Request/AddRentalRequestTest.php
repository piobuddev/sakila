<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Rental\Service\Request;

use Sakila\Command\CommandInterface;
use Sakila\Domain\Rental\Service\Request\AddRentalRequest;
use Sakila\Test\AbstractUnitTestCase;

class AddRentalRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $cut        = new AddRentalRequest($attributes);

        $this->assertInstanceOf(CommandInterface::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
