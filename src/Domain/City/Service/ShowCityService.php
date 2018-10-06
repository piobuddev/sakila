<?php declare(strict_types=1);

namespace Sakila\Domain\City\Service;

use Sakila\Domain\City\Entity\Transformer\CityTransformerInterface;
use Sakila\Domain\City\Repository\CityRepository;
use Sakila\Domain\City\Service\Request\ShowCityRequest;
use Sakila\Transformer\Transformer;

class ShowCityService
{
    /**
     * @var \Sakila\Domain\City\Repository\CityRepository
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\City\Repository\CityRepository $repository
     * @param \Sakila\Transformer\Transformer               $transformer
     */
    public function __construct(CityRepository $repository, Transformer $transformer)
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
