<?php declare(strict_types=1);

namespace Sakila\Domain\Country\Service;

use Sakila\Domain\Country\Repository\CountryRepositoryInterface;
use Sakila\Domain\Country\Service\Request\RemoveCountryRequest;

class RemoveCountryService
{
    /**
     * @var \Sakila\Domain\Country\Repository\CountryRepositoryInterface
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Country\Repository\CountryRepositoryInterface $repository
     */
    public function __construct(CountryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Sakila\Domain\Country\Service\Request\RemoveCountryRequest $removeCountryRequest
     *
     * @return bool
     */
    public function execute(RemoveCountryRequest $removeCountryRequest): bool
    {
        return $this->repository->remove($removeCountryRequest->getCountryId());
    }
}
