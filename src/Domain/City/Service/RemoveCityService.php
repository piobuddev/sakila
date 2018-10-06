<?php declare(strict_types=1);

namespace Sakila\Domain\City\Service;

use Sakila\Domain\City\Repository\CityRepository;
use Sakila\Domain\City\Service\Request\RemoveCityRequest;

class RemoveCityService
{
    /**
     * @var \Sakila\Domain\City\Repository\CityRepository
     */
    private $repository;

    /**
     * @param \Sakila\Domain\City\Repository\CityRepository $repository
     */
    public function __construct(CityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(RemoveCityRequest $removeCityRequest)
    {
        return $this->repository->remove($removeCityRequest->getCityId());
    }
}
