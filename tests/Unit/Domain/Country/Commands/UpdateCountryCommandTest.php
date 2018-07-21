<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Actor\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Country\Commands\UpdateCountryCommand;
use Sakila\Test\AbstractUnitTestCase;

class UpdateCountryCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['country' => 'Germany'];
        $countryId  = 1;
        $cut        = new UpdateCountryCommand($countryId, $attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($countryId, $cut->getCountryId());
    }
}
