<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Category\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Category\Commands\UpdateCategoryCommand;
use Sakila\Test\AbstractUnitTestCase;

class UpdateCategoryCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['name' => 'Action'];
        $categoryId = 1;
        $cut        = new UpdateCategoryCommand($categoryId, $attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($categoryId, $cut->getCategoryId());
    }
}
