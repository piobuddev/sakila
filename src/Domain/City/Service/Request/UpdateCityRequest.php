<?php declare(strict_types=1);

namespace Sakila\Domain\City\Service\Request;

use Sakila\Command\AbstractCommand;

class UpdateCityRequest extends AbstractCommand
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
        $this->attributes = $attributes;
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
