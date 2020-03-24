<?php declare(strict_types=1);

namespace Sakila\Domain\Country\Service;

use Sakila\Domain\Country\Entity\Mapper\CountryMapper;
use Sakila\Domain\Country\Entity\Transformer\CountryTransformerInterface;
use Sakila\Domain\Country\Repository\CountryRepositoryInterface;
use Sakila\Domain\Country\Service\Request\UpdateCountryRequest;
use Sakila\Domain\Country\Validator\CountryValidatorInterface;
use Sakila\Transformer\TransformerInterface;

class UpdateCountryService
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
     * @param \Sakila\Domain\Country\Service\Request\UpdateCountryRequest $updateCountryRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(UpdateCountryRequest $updateCountryRequest)
    {
        $this->validator->validate(
            array_merge(
                ['country_id' => $updateCountryRequest->getCountryId()],
                $updateCountryRequest->getAttributes()
            )
        );

        $country = $this->countryRepository->update(
            $updateCountryRequest->getCountryId(),
            $this->countryMapper->map($updateCountryRequest->getAttributes())
        );

        return $this->transformer->item($country, CountryTransformerInterface::class);
    }
}
