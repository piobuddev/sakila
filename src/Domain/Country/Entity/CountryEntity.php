<?php declare(strict_types=1);

namespace Sakila\Domain\Country\Entity;

use Sakila\Entity\AbstractEntity;

class CountryEntity extends AbstractEntity
{
    /**
     * @var int
     */
    public $countryId;

    /**
     * @var string
     */
    public $country;
}
