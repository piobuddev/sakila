<?php declare(strict_types=1);

namespace Sakila\Domain\Country\Commands;

use Sakila\Command\AbstractCommand;
use Sakila\Domain\Country\Entity\CountryEntity;

class UpdateCountryCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $countryId;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param int   $countryId
     * @param array $attributes
     */
    public function __construct(int $countryId, array $attributes)
    {
        $this->countryId  = $countryId;
        $this->attributes = $this->filterAttributes($attributes, CountryEntity::class);
    }

    /**
     * @return int
     */
    public function getCountryId(): int
    {
        return $this->countryId;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
