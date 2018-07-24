<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Category\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Category\Commands\AddCategoryCommand;
use Sakila\Test\AbstractUnitTestCase;

class AddCategoryCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['name' => 'Action'];
        $cut        = new AddCategoryCommand($attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
