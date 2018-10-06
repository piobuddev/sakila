<?php declare(strict_types=1);

namespace Sakila\Domain\City\Service\Request;

use Sakila\Command\Command;

class ShowCityRequest implements Command
{
    /**
     * @var int
     */
    private $cityId;

    /**
     * @param int $cityId
     */
    public function __construct(int $cityId)
    {
        $this->setCityId($cityId);
    }

    /**
     * @return int
     */
    public function getCityId(): int
    {
        return $this->cityId;
    }

    /**
     * @param int $cityId
     */
    private function setCityId(int $cityId): void
    {
        $this->cityId = $cityId;
    }
}
