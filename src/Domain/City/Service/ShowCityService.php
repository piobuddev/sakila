<?php declare(strict_types=1);

namespace Sakila\Domain\City\Service;

use Sakila\Domain\City\Entity\Transformer\CityTransformerInterface;
use Sakila\Domain\City\Repository\CityRepositoryInterface;
use Sakila\Domain\City\Service\Request\ShowCityRequest;
use Sakila\Transformer\TransformerInterface;

class ShowCityService
{
    /**
     * @var \Sakila\Domain\City\Repository\CityRepositoryInterface
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\City\Repository\CityRepositoryInterface $repository
     * @param \Sakila\Transformer\TransformerInterface               $transformer
     */
    public function __construct(CityRepositoryInterface $repository, TransformerInterface $transformer)
    {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\City\Service\Request\ShowCityRequest $showCityRequest
     *
     * @return mixed
     */
    public function execute(ShowCityRequest $showCityRequest)
    {
        $city = $this->repository->get($showCityRequest->getCityId());

        return $this->transformer->item($city, CityTransformerInterface::class);
    }
}
