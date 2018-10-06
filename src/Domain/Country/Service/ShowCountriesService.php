<?php declare(strict_types=1);

namespace Sakila\Domain\Country\Service;

use Sakila\Domain\Country\Entity\Transformer\CountryTransformerInterface;
use Sakila\Domain\Country\Repository\CountryRepository;
use Sakila\Domain\Country\Service\Request\ShowCountriesRequest;
use Sakila\Transformer\Transformer;

class ShowCountriesService
{
    /**
     * @var \Sakila\Domain\Country\Repository\CountryRepository
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Country\Repository\CountryRepository $repository
     * @param \Sakila\Transformer\Transformer                     $transformer
     */
    public function __construct(
        CountryRepository $repository,
        Transformer $transformer
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
