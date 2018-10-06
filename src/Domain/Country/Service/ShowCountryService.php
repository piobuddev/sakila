<?php declare(strict_types=1);

namespace Sakila\Domain\Country\Service;

use Sakila\Domain\Country\Entity\Transformer\CountryTransformerInterface;
use Sakila\Domain\Country\Repository\CountryRepository;
use Sakila\Domain\Country\Service\Request\ShowCountryRequest;
use Sakila\Transformer\Transformer;

class ShowCountryService
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
    public function __construct(CountryRepository $repository, Transformer $transformer)
    {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Country\Service\Request\ShowCountryRequest $showCountryRequest
     *
     * @return mixed
     */
    public function execute(ShowCountryRequest $showCountryRequest)
    {
        $country = $this->repository->get($showCountryRequest->getCountryId());

        return $this->transformer->item($country, CountryTransformerInterface::class);
    }
}
