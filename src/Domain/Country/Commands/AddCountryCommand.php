<?php declare(strict_types=1);

namespace Sakila\Domain\Country\Commands;

use Sakila\Command\AbstractCommand;
use Sakila\Domain\Country\Entity\CountryEntity;

class AddCountryCommand extends AbstractCommand
{
    /**
     * @var array
     */
    private $attributes;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $this->filterAttributes($attributes, CountryEntity::class);
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }
}
