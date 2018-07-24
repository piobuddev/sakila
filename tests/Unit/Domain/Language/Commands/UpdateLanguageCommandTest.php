<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Language\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Language\Commands\UpdateLanguageCommand;
use Sakila\Test\AbstractUnitTestCase;

class UpdateLanguageCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['name' => 'English'];
        $languageId = 1;
        $cut        = new UpdateLanguageCommand($languageId, $attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($languageId, $cut->getLanguageId());
    }
}
