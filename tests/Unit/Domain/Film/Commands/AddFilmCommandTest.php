<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Film\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Film\Commands\AddFilmCommand;
use Sakila\Test\AbstractUnitTestCase;

class AddFilmCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $cut        = new AddFilmCommand($attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
