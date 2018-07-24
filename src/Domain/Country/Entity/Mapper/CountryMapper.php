<?php declare(strict_types=1);

namespace Sakila\Domain\Country\Entity\Mapper;

use Sakila\Entity\Mapper\AbstractMapper;

class CountryMapper extends AbstractMapper
{
    /**
     * @return array
     */
    protected function getMapping(): array
    {
        return [
            'id'      => 'country_id',
            'country' => 'country',
        ];
    }
}
