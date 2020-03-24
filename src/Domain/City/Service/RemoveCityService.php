<?php declare(strict_types=1);

namespace Sakila\Domain\City\Service;

use Sakila\Domain\City\Repository\CityRepositoryInterface;
use Sakila\Domain\City\Service\Request\RemoveCityRequest;

class RemoveCityService
{
    /**
     * @var \Sakila\Domain\City\Repository\CityRepositoryInterface
     */
    private $repository;

    /**
     * @param \Sakila\Domain\City\Repository\CityRepositoryInterface $repository
     */
    public function __construct(CityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Sakila\Domain\City\Service\Request\RemoveCityRequest $removeCityRequest
     *
     * @return bool
     */
    public function execute(RemoveCityRequest $removeCityRequest): bool
    {
        return $this->repository->remove($removeCityRequest->getCityId());
    }
}
