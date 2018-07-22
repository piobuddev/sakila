<?php declare(strict_types=1);

namespace Sakila\Domain\City\Entity\Mapper;

use Sakila\Entity\Mapper\AbstractMapper;

class CityMapper extends AbstractMapper
{
    /**
     * @return array
     */
    protected function getMapping(): array
    {
        return [
            'id'        => 'city_id',
            'countryId' => 'country_id',
        ];
    }
}
