<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Category\Entity\Mapper;

use Sakila\Domain\Category\Entity\Mapper\CategoryMapper;
use Sakila\Test\AbstractUnitTestCase;

class CategoryMapperTest extends AbstractUnitTestCase
{
    public function testMapToExpectedFields()
    {
        $data     = ['id' => 1, 'name' => 'Action'];
        $expected = ['category_id' => 1, 'name' => 'Action'];
        $cut      = new CategoryMapper();

        $this->assertEquals($expected, $cut->map($data));
    }

    public function testMapperFiltersOutIncorrectFields()
    {
        $data     = ['id' => 1, 'name' => 'Action', 'foo' => 'bar'];
        $expected = ['category_id' => 1, 'name' => 'Action'];
        $cut      = new CategoryMapper();

        $this->assertEquals($expected, $cut->map($data));
    }
}
