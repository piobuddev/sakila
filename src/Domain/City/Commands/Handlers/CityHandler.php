<?php declare(strict_types=1);

namespace Sakila\Domain\City\Commands\Handlers;

use Sakila\Domain\City\Commands\AddCityCommand;
use Sakila\Domain\City\Commands\UpdateCityCommand;
use Sakila\Domain\City\Entity\Mapper\CityMapper;
use Sakila\Domain\City\Repository\CityRepository;
use Sakila\Domain\City\Validator\CityValidator;
use Sakila\Entity\EntityInterface;

class CityHandler
{
    /**
     * @var \Sakila\Domain\City\Entity\Mapper\CityMapper
     */
    private $cityMapper;

    /**
     * @var \Sakila\Domain\City\Repository\CityRepository
     */
    private $cityRepository;

    /**
     * @var \Sakila\Domain\City\Validator\CityValidator
     */
    private $validator;

    /**
     * @param \Sakila\Domain\City\Entity\Mapper\CityMapper  $mapper
     * @param \Sakila\Domain\City\Repository\CityRepository $repository
     * @param \Sakila\Domain\City\Validator\CityValidator   $validator
     */
    public function __construct(CityMapper $mapper, CityRepository $repository, CityValidator $validator)
    {
        $this->cityMapper     = $mapper;
        $this->cityRepository = $repository;
        $this->validator      = $validator;
    }

    /**
     * @param \Sakila\Domain\City\Commands\AddCityCommand $command
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function handleAddCity(AddCityCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->cityRepository->add($this->cityMapper->map($command->getAttributes()));

        $cityId = $this->cityRepository->lastInsertedId();
        $city   = $this->cityRepository->get($cityId);

        return $city;
    }

    /**
     * @param \Sakila\Domain\City\Commands\UpdateCityCommand $command
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function handleUpdateCity(UpdateCityCommand $command): EntityInterface
    {
        $attributes = array_merge(['city_id' => $command->getCityId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->cityRepository->update(
            $command->getCityId(),
            $this->cityMapper->map($command->getAttributes())
        );
    }
}
