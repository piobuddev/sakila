<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Category\Service\Request;

use Sakila\Command\Command;
use Sakila\Domain\Category\Service\Request\AddCategoryRequest;
use Sakila\Test\AbstractUnitTestCase;

class AddCategoryRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['name' => 'Action'];
        $cut        = new AddCategoryRequest($attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
