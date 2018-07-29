<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Film\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Film\Commands\UpdateFilmCommand;
use Sakila\Test\AbstractUnitTestCase;

class UpdateFilmCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $filmId     = 1;
        $cut        = new UpdateFilmCommand($filmId, $attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($filmId, $cut->getFilmId());
    }
}
