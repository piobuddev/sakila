<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Country\Entity\Mapper;

use Sakila\Domain\Country\Entity\Mapper\CountryMapper;
use Sakila\Test\AbstractUnitTestCase;

class CountryMapperTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedMapping()
    {
        $cut        = new CountryMapper();
        $expected   = ['country_id' => 1, 'country' => 'Japan'];
        $attributes = ['id' => 1, 'country' => 'Japan'];

        $this->assertEquals($expected, $cut->map($attributes));
    }
}
