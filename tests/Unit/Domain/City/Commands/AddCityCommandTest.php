<?php declare(strict_types=1);

namespace Sakila\Test\Domain\City\Commands;

use Sakila\Command\Command;
use Sakila\Domain\City\Commands\AddCityCommand;
use Sakila\Test\AbstractUnitTestCase;

class AddCityCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['city' => 'NY'];
        $cut        = new AddCityCommand($attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
