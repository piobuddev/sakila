<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Rental\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Rental\Commands\UpdateRentalCommand;
use Sakila\Test\AbstractUnitTestCase;

class UpdateRentalCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $rentalId   = 1;
        $cut        = new UpdateRentalCommand($rentalId, $attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($rentalId, $cut->getRentalId());
    }
}
