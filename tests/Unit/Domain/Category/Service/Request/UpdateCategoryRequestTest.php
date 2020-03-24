<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Category\Service\Request;

use Sakila\Command\CommandInterface;
use Sakila\Domain\Category\Service\Request\UpdateCategoryRequest;
use Sakila\Test\AbstractUnitTestCase;

class UpdateCategoryRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['name' => 'Action'];
        $categoryId = 1;
        $cut        = new UpdateCategoryRequest($categoryId, $attributes);

        $this->assertInstanceOf(CommandInterface::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($categoryId, $cut->getCategoryId());
    }
}
