<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Actor\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Country\Commands\AddCountryCommand;
use Sakila\Test\AbstractUnitTestCase;

class AddCountryCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['country' => 'Italy'];
        $cut        = new AddCountryCommand($attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
