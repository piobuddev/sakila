<?php declare(strict_types=1);

namespace Sakila\Test\Domain\City\Entity\Mapper;

use Sakila\Domain\City\Entity\Mapper\CityMapper;
use Sakila\Test\AbstractUnitTestCase;

class CityMapperTest extends AbstractUnitTestCase
{
    public function testMapToExpectedFields()
    {
        $data     = ['id' => 1, 'city' => 'London'];
        $expected = ['city_id' => 1, 'city' => 'London'];
        $cut      = new CityMapper();

        $this->assertEquals($expected, $cut->map($data));
    }

    public function testMapperFiltersOutIncorrectFields()
    {
        $data     = ['id' => 1, 'city' => 'London', 'foo' => 'bar'];
        $expected = ['city_id' => 1, 'city' => 'London'];
        $cut      = new CityMapper();

        $this->assertEquals($expected, $cut->map($data));
    }
}
