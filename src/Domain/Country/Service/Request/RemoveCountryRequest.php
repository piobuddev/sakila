<?php declare(strict_types=1);

namespace Sakila\Domain\Country\Service\Request;

use Sakila\Command\Command;

class RemoveCountryRequest implements Command
{
    /**
     * @var int
     */
    private $countryId;

    /**
     * @param int $countryId
     */
    public function __construct(int $countryId)
    {
        $this->setCountryId($countryId);
    }

    /**
     * @return int
     */
    public function getCountryId(): int
    {
        return $this->countryId;
    }

    /**
     * @param int $countryId
     */
    private function setCountryId(int $countryId): void
    {
        $this->countryId = $countryId;
    }
}
