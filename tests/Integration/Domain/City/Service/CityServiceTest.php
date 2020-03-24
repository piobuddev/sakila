<?php

namespace Sakila\Test\Domain\City\Requests\Handlers;

use Sakila\Domain\City\Entity\Mapper\CityMapper;
use Sakila\Domain\City\Entity\Transformer\CityTransformerInterface;
use Sakila\Domain\City\Repository\CityRepositoryInterface;
use Sakila\Domain\City\Service\AddCityService;
use Sakila\Domain\City\Service\Request\AddCityRequest;
use Sakila\Domain\City\Service\Request\UpdateCityRequest;
use Sakila\Domain\City\Service\UpdateCityService;
use Sakila\Domain\City\Validator\CityValidatorInterface;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;
use Sakila\Transformer\TransformerInterface;

class CityServiceTest extends AbstractIntegrationTestCase
{
    public function testAddCity()
    {
        $request = new AddCityRequest(['foo' => 'bar']);

        $validator = $this->createMock(CityValidatorInterface::class);
        $validator->expects($this->once())->method('validate')->with($request->getAttributes());

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(CityMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(CityRepositoryInterface::class);
        $repository->expects($this->once())->method('add')->with($mapped);
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $transformer = $this->createMock(TransformerInterface::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, CityTransformerInterface::class)
            ->willReturn($entity);

        $service = new AddCityService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }

    public function testUpdateCity()
    {
        $cityId = 1;
        $request = new UpdateCityRequest($cityId, ['foo' => 'bar']);

        $attributes = array_merge(['city_id' => $request->getCityId()], $request->getAttributes());
        $validator  = $this->createMock(CityValidatorInterface::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(CityMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(CityRepositoryInterface::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($request->getCityId(), $mapped)
            ->willReturn($entity);

        $transformer = $this->createMock(TransformerInterface::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, CityTransformerInterface::class)
            ->willReturn($entity);

        $service = new UpdateCityService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }
}
