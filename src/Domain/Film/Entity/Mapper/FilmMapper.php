<?php declare(strict_types=1);

namespace Sakila\Domain\Film\Entity\Mapper;

use Sakila\Entity\Mapper\AbstractMapper;

class FilmMapper extends AbstractMapper
{
    /**
     * @return array
     */
    protected function getMapping(): array
    {
        return [
            'filmId'             => 'film_id',
            'title'              => 'title',
            'description'        => 'description',
            'releaseYear'        => 'release_year',
            'languageId'         => 'language_id',
            'originalLanguageId' => 'original_language_id',
            'rentalDuration'     => 'rental_duration',
            'rentalRate'         => 'rental_rate',
            'length'             => 'length',
            'replacementCost'    => 'replacement_cost',
            'rating'             => 'rating',
            'specialFeatures'    => 'special_features',
        ];
    }
}
