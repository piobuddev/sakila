<?php

namespace Sakila\Test\Domain\Country\Requests\Handlers;

use Sakila\Domain\Country\Entity\Mapper\CountryMapper;
use Sakila\Domain\Country\Entity\Transformer\CountryTransformerInterface;
use Sakila\Domain\Country\Repository\CountryRepositoryInterface;
use Sakila\Domain\Country\Service\AddCountryService;
use Sakila\Domain\Country\Service\Request\AddCountryRequest;
use Sakila\Domain\Country\Service\Request\UpdateCountryRequest;
use Sakila\Domain\Country\Service\UpdateCountryService;
use Sakila\Domain\Country\Validator\CountryValidatorInterface;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;
use Sakila\Transformer\TransformerInterface;

class CountryServiceTest extends AbstractIntegrationTestCase
{
    public function testAddCountry()
    {
        $request = new AddCountryRequest(['foo' => 'bar']);

        $validator = $this->createMock(CountryValidatorInterface::class);
        $validator->expects($this->once())->method('validate')->with($request->getAttributes());

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(CountryMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(CountryRepositoryInterface::class);
        $repository->expects($this->once())->method('add')->with($mapped);
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $transformer = $this->createMock(TransformerInterface::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, CountryTransformerInterface::class)
            ->willReturn($entity);

        $service = new AddCountryService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }

    public function testUpdateCountry()
    {
        $countryId = 1;
        $request = new UpdateCountryRequest($countryId, ['foo' => 'bar']);

        $attributes = array_merge(['country_id' => $request->getCountryId()], $request->getAttributes());
        $validator  = $this->createMock(CountryValidatorInterface::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(CountryMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(CountryRepositoryInterface::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($request->getCountryId(), $mapped)
            ->willReturn($entity);

        $transformer = $this->createMock(TransformerInterface::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, CountryTransformerInterface::class)
            ->willReturn($entity);

        $service = new UpdateCountryService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }
}
