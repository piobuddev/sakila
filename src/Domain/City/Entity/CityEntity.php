<?php declare(strict_types=1);

namespace Sakila\Domain\City\Entity;

use Sakila\Entity\AbstractEntity;

class CityEntity extends AbstractEntity
{
    /**
     * @var int
     */
    public $cityId;

    /**
     * @var string
     */
    public $city;

    /**
     * @var int
     */
    public $countryId;
}
