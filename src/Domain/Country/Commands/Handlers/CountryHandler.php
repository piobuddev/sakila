<?php declare(strict_types=1);

namespace Sakila\Domain\Country\Commands\Handlers;

use Sakila\Domain\Country\Commands\AddCountryCommand;
use Sakila\Domain\Country\Commands\UpdateCountryCommand;
use Sakila\Domain\Country\Entity\CountryEntity;
use Sakila\Domain\Country\Entity\Mapper\CountryMapper;
use Sakila\Domain\Country\Repository\CountryRepository;
use Sakila\Domain\Country\Validator\CountryValidator;
use Sakila\Exceptions\UnexpectedValueException;

class CountryHandler
{
    /**
     * @var \Sakila\Domain\Country\Entity\Mapper\CountryMapper
     */
    private $countryMapper;

    /**
     * @var \Sakila\Domain\Country\Repository\CountryRepository
     */
    private $countryRepository;

    /**
     * @var \Sakila\Domain\Country\Validator\CountryValidator
     */
    private $validator;

    /**
     * @param \Sakila\Domain\Country\Entity\Mapper\CountryMapper  $mapper
     * @param \Sakila\Domain\Country\Repository\CountryRepository $repository
     * @param \Sakila\Domain\Country\Validator\CountryValidator   $validator
     */
    public function __construct(CountryMapper $mapper, CountryRepository $repository, CountryValidator $validator)
    {
        $this->countryMapper     = $mapper;
        $this->countryRepository = $repository;
        $this->validator         = $validator;
    }

    /**
     * @param \Sakila\Domain\Country\Commands\AddCountryCommand $command
     *
     * @return \Sakila\Domain\Country\Entity\CountryEntity
     * @throws \Sakila\Exceptions\UnexpectedValueException
     */
    public function handleAddCountry(AddCountryCommand $command): CountryEntity
    {
        $this->validator->validate($command->getAttributes());
        $this->countryRepository->add($this->countryMapper->map($command->getAttributes()));

        $countryId = $this->countryRepository->lastInsertedId();
        $country   = $this->countryRepository->get($countryId);
        if (!$country instanceof CountryEntity) {
            throw new UnexpectedValueException();
        }

        return $country;
    }

    /**
     * @param \Sakila\Domain\Country\Commands\UpdateCountryCommand $command
     *
     * @return \Sakila\Domain\Country\Entity\CountryEntity
     */
    public function handleUpdateCountry(UpdateCountryCommand $command): CountryEntity
    {
        $attributes = array_merge(['country_id' => $command->getCountryId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->countryRepository->update(
            $command->getCountryId(),
            $this->countryMapper->map($command->getAttributes())
        );
    }
}
