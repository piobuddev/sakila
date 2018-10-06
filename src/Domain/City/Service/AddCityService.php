<?php declare(strict_types=1);

namespace Sakila\Domain\City\Service;

use Sakila\Domain\City\Entity\Mapper\CityMapper;
use Sakila\Domain\City\Entity\Transformer\CityTransformerInterface;
use Sakila\Domain\City\Repository\CityRepository;
use Sakila\Domain\City\Service\Request\AddCityRequest;
use Sakila\Domain\City\Validator\CityValidator;
use Sakila\Transformer\Transformer;

class AddCityService
{
    /**
     * @var \Sakila\Domain\City\Validator\CityValidator
     */
    private $validator;

    /**
     * @var \Sakila\Domain\City\Repository\CityRepository
     */
    private $cityRepository;

    /**
     * @var \Sakila\Domain\City\Entity\Mapper\CityMapper
     */
    private $cityMapper;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\City\Validator\CityValidator   $validator
     * @param \Sakila\Domain\City\Repository\CityRepository $repository
     * @param \Sakila\Domain\City\Entity\Mapper\CityMapper  $cityMapper
     * @param \Sakila\Transformer\Transformer               $transformer
     */
    public function __construct(
        CityValidator $validator,
        CityRepository $repository,
        CityMapper $cityMapper,
        Transformer $transformer
    ) {
        $this->validator      = $validator;
        $this->cityRepository = $repository;
        $this->cityMapper     = $cityMapper;
        $this->transformer    = $transformer;
    }

    /**
     * @param \Sakila\Domain\City\Service\Request\AddCityRequest $addCityRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(AddCityRequest $addCityRequest)
    {
        $this->validator->validate($addCityRequest->getAttributes());
        $this->cityRepository->add($this->cityMapper->map($addCityRequest->getAttributes()));

        $cityId = $this->cityRepository->lastInsertedId();
        $city   = $this->cityRepository->get($cityId);

        return $this->transformer->item($city, CityTransformerInterface::class);
    }
}
