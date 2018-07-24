<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Language\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Language\Commands\AddLanguageCommand;
use Sakila\Test\AbstractUnitTestCase;

class AddLanguageCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['name' => 'English'];
        $cut        = new AddLanguageCommand($attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
