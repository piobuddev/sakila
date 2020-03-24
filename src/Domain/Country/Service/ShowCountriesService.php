<?php declare(strict_types=1);

namespace Sakila\Domain\Country\Service;

use Sakila\Domain\Country\Entity\Transformer\CountryTransformerInterface;
use Sakila\Domain\Country\Repository\CountryRepositoryInterface;
use Sakila\Domain\Country\Service\Request\ShowCountriesRequest;
use Sakila\Transformer\TransformerInterface;

class ShowCountriesService
{
    /**
     * @var \Sakila\Domain\Country\Repository\CountryRepositoryInterface
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Country\Repository\CountryRepositoryInterface $repository
     * @param \Sakila\Transformer\TransformerInterface                     $transformer
     */
    public function __construct(
        CountryRepositoryInterface $repository,
        TransformerInterface $transformer
    ) {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Country\Service\Request\ShowCountriesRequest $showCountriesRequest
     *
     * @return mixed
     */
    public function execute(ShowCountriesRequest $showCountriesRequest)
    {
        $page      = $showCountriesRequest->getPage();
        $pageSize  = $showCountriesRequest->getPageSize();
        $countries = $this->repository->all($page, $pageSize);
        $total     = $this->repository->count();

        return $this->transformer->collection(
            $countries,
            CountryTransformerInterface::class,
            $page,
            $pageSize,
            $total
        );
    }
}
