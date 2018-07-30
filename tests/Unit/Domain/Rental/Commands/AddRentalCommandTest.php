<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Rental\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Rental\Commands\AddRentalCommand;
use Sakila\Test\AbstractUnitTestCase;

class AddRentalCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $cut        = new AddRentalCommand($attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
