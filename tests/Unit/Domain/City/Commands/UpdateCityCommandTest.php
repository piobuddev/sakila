<?php declare(strict_types=1);

namespace Sakila\Test\Domain\City\Commands;

use Sakila\Command\Command;
use Sakila\Domain\City\Commands\UpdateCityCommand;
use Sakila\Test\AbstractUnitTestCase;

class UpdateCityCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['city' => 'NY'];
        $cityId     = 1;
        $cut        = new UpdateCityCommand($cityId, $attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($cityId, $cut->getCityId());
    }
}
