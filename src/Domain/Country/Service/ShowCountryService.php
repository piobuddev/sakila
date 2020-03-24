<?php declare(strict_types=1);

namespace Sakila\Domain\Country\Service;

use Sakila\Domain\Country\Entity\Transformer\CountryTransformerInterface;
use Sakila\Domain\Country\Repository\CountryRepositoryInterface;
use Sakila\Domain\Country\Service\Request\ShowCountryRequest;
use Sakila\Transformer\TransformerInterface;

class ShowCountryService
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
    public function __construct(CountryRepositoryInterface $repository, TransformerInterface $transformer)
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
