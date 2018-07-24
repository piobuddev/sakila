<?php

namespace Sakila\Test\Domain\City\Commands\Handlers;

use Sakila\Domain\City\Commands\AddCityCommand;
use Sakila\Domain\City\Commands\Handlers\CityHandler;
use Sakila\Domain\City\Commands\UpdateCityCommand;
use Sakila\Domain\City\Entity\Mapper\CityMapper;
use Sakila\Domain\City\Repository\CityRepository;
use Sakila\Domain\City\Validator\CityValidator;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;

class CityHandlerTest extends AbstractIntegrationTestCase
{
    public function testAddCity()
    {
        $command = new AddCityCommand(['foo' => 'bar']);

        $validator = $this->createMock(CityValidator::class);
        $validator->expects($this->once())->method('validate')->with($command->getAttributes());

        $mapper = new CityMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(CityRepository::class);
        $repository->expects($this->once())->method('add')->with($mapper->map($command->getAttributes()));
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $handler = new CityHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleAddCity($command));
    }

    public function testUpdateCity()
    {
        $cityId  = 1;
        $command = new UpdateCityCommand($cityId, ['foo' => 'bar']);

        $attributes = array_merge(['city_id' => $command->getCityId()], $command->getAttributes());
        $validator  = $this->createMock(CityValidator::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $mapper = new CityMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(CityRepository::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($command->getCityId(), $mapper->map($command->getAttributes()))
            ->willReturn($entity);

        $handler = new CityHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleUpdateCity($command));
    }
}
