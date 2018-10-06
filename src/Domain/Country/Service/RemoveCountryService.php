<?php declare(strict_types=1);

namespace Sakila\Domain\Country\Service;

use Sakila\Domain\Country\Repository\CountryRepository;
use Sakila\Domain\Country\Service\Request\RemoveCountryRequest;

class RemoveCountryService
{
    /**
     * @var \Sakila\Domain\Country\Repository\CountryRepository
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Country\Repository\CountryRepository $repository
     */
    public function __construct(CountryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(RemoveCountryRequest $removeCountryRequest)
    {
        return $this->repository->remove($removeCountryRequest->getCountryId());
    }
}
