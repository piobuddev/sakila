<?php declare(strict_types=1);

namespace Sakila\Domain\Country\Service;

use Sakila\Domain\Country\Entity\Mapper\CountryMapper;
use Sakila\Domain\Country\Entity\Transformer\CountryTransformerInterface;
use Sakila\Domain\Country\Repository\CountryRepository;
use Sakila\Domain\Country\Service\Request\AddCountryRequest;
use Sakila\Domain\Country\Validator\CountryValidator;
use Sakila\Transformer\Transformer;

class AddCountryService
{
    /**
     * @var \Sakila\Domain\Country\Validator\CountryValidator
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Country\Repository\CountryRepository
     */
    private $countryRepository;

    /**
     * @var \Sakila\Domain\Country\Entity\Mapper\CountryMapper
     */
    private $countryMapper;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Country\Validator\CountryValidator   $validator
     * @param \Sakila\Domain\Country\Repository\CountryRepository $repository
     * @param \Sakila\Domain\Country\Entity\Mapper\CountryMapper  $countryMapper
     * @param \Sakila\Transformer\Transformer                     $transformer
     */
    public function __construct(
        CountryValidator $validator,
        CountryRepository $repository,
        CountryMapper $countryMapper,
        Transformer $transformer
    ) {
        $this->validator         = $validator;
        $this->countryRepository = $repository;
        $this->countryMapper     = $countryMapper;
        $this->transformer       = $transformer;
    }

    /**
     * @param \Sakila\Domain\Country\Service\Request\AddCountryRequest $addCountryRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(AddCountryRequest $addCountryRequest)
    {
        $this->validator->validate($addCountryRequest->getAttributes());
        $this->countryRepository->add($this->countryMapper->map($addCountryRequest->getAttributes()));

        $countryId = $this->countryRepository->lastInsertedId();
        $country   = $this->countryRepository->get($countryId);

        return $this->transformer->item($country, CountryTransformerInterface::class);
    }
}
