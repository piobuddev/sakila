<?php declare(strict_types=1);

namespace Sakila\Domain\City\Commands;

use Sakila\Command\AbstractCommand;
use Sakila\Domain\City\Entity\CityEntity;

class UpdateCityCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $cityId;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param int   $cityId
     * @param array $attributes
     */
    public function __construct(int $cityId, array $attributes)
    {
        $this->cityId     = $cityId;
        $this->attributes = $this->filterAttributes($attributes, CityEntity::class);
    }

    /**
     * @return int
     */
    public function getCityId(): int
    {
        return $this->cityId;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
