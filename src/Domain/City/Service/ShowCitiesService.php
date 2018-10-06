<?php declare(strict_types=1);

namespace Sakila\Domain\City\Service;

use Sakila\Domain\City\Entity\Transformer\CityTransformerInterface;
use Sakila\Domain\City\Repository\CityRepository;
use Sakila\Domain\City\Service\Request\ShowCitiesRequest;
use Sakila\Transformer\Transformer;

class ShowCitiesService
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
    public function __construct(
        CityRepository $repository,
        Transformer $transformer
    ) {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\City\Service\Request\ShowCitiesRequest $showCitiesRequest
     *
     * @return mixed
     */
    public function execute(ShowCitiesRequest $showCitiesRequest)
    {
        $page     = $showCitiesRequest->getPage();
        $pageSize = $showCitiesRequest->getPageSize();
        $cities   = $this->repository->all($page, $pageSize);
        $total    = $this->repository->count();

        return $this->transformer->collection(
            $cities,
            CityTransformerInterface::class,
            $page,
            $pageSize,
            $total
        );
    }
}
