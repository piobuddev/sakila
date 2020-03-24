<?php declare(strict_types=1);

namespace Sakila\Domain\City\Service;

use Sakila\Domain\City\Entity\Mapper\CityMapper;
use Sakila\Domain\City\Entity\Transformer\CityTransformerInterface;
use Sakila\Domain\City\Repository\CityRepositoryInterface;
use Sakila\Domain\City\Service\Request\UpdateCityRequest;
use Sakila\Domain\City\Validator\CityValidatorInterface;
use Sakila\Transformer\TransformerInterface;

class UpdateCityService
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
     * @param \Sakila\Domain\City\Service\Request\UpdateCityRequest $updateCityRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(UpdateCityRequest $updateCityRequest)
    {
        $this->validator->validate(
            array_merge(
                ['city_id' => $updateCityRequest->getCityId()],
                $updateCityRequest->getAttributes()
            )
        );

        $city = $this->cityRepository->update(
            $updateCityRequest->getCityId(),
            $this->cityMapper->map($updateCityRequest->getAttributes())
        );

        return $this->transformer->item($city, CityTransformerInterface::class);
    }
}
