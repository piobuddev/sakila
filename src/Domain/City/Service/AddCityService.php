<?php declare(strict_types=1);

namespace Sakila\Domain\City\Service;

use Sakila\Domain\City\Entity\Mapper\CityMapper;
use Sakila\Domain\City\Entity\Transformer\CityTransformerInterface;
use Sakila\Domain\City\Repository\CityRepositoryInterface;
use Sakila\Domain\City\Service\Request\AddCityRequest;
use Sakila\Domain\City\Validator\CityValidatorInterface;
use Sakila\Transformer\TransformerInterface;

class AddCityService
{
    /**
     * @var \Sakila\Domain\City\Validator\CityValidatorInterface
     */
    private $validator;

    /**
     * @var \Sakila\Domain\City\Repository\CityRepositoryInterface
     */
    private $cityRepository;

    /**
     * @var \Sakila\Domain\City\Entity\Mapper\CityMapper
     */
    private $cityMapper;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\City\Validator\CityValidatorInterface   $validator
     * @param \Sakila\Domain\City\Repository\CityRepositoryInterface $repository
     * @param \Sakila\Domain\City\Entity\Mapper\CityMapper           $cityMapper
     * @param \Sakila\Transformer\TransformerInterface               $transformer
     */
    public function __construct(
        CityValidatorInterface $validator,
        CityRepositoryInterface $repository,
        CityMapper $cityMapper,
        TransformerInterface $transformer
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
