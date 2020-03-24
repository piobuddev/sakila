<?php declare(strict_types=1);

namespace Sakila\Domain\Country\Service;

use Sakila\Domain\Country\Entity\Mapper\CountryMapper;
use Sakila\Domain\Country\Entity\Transformer\CountryTransformerInterface;
use Sakila\Domain\Country\Repository\CountryRepositoryInterface;
use Sakila\Domain\Country\Service\Request\AddCountryRequest;
use Sakila\Domain\Country\Validator\CountryValidatorInterface;
use Sakila\Transformer\TransformerInterface;

class AddCountryService
{
    /**
     * @var \Sakila\Domain\Country\Validator\CountryValidatorInterface
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Country\Repository\CountryRepositoryInterface
     */
    private $countryRepository;

    /**
     * @var \Sakila\Domain\Country\Entity\Mapper\CountryMapper
     */
    private $countryMapper;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Country\Validator\CountryValidatorInterface   $validator
     * @param \Sakila\Domain\Country\Repository\CountryRepositoryInterface $repository
     * @param \Sakila\Domain\Country\Entity\Mapper\CountryMapper           $countryMapper
     * @param \Sakila\Transformer\TransformerInterface                     $transformer
     */
    public function __construct(
        CountryValidatorInterface $validator,
        CountryRepositoryInterface $repository,
        CountryMapper $countryMapper,
        TransformerInterface $transformer
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
