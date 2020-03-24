<?php declare(strict_types=1);

namespace Sakila\Domain\City\Service;

use Sakila\Domain\City\Entity\Transformer\CityTransformerInterface;
use Sakila\Domain\City\Repository\CityRepositoryInterface;
use Sakila\Domain\City\Service\Request\ShowCitiesRequest;
use Sakila\Transformer\TransformerInterface;

class ShowCitiesService
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
    public function __construct(
        CityRepositoryInterface $repository,
        TransformerInterface $transformer
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
