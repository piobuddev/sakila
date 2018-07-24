<?php

namespace Sakila\Test\Domain\Country\Commands\Handlers;

use Sakila\Domain\Country\Commands\AddCountryCommand;
use Sakila\Domain\Country\Commands\Handlers\CountryHandler;
use Sakila\Domain\Country\Commands\UpdateCountryCommand;
use Sakila\Domain\Country\Entity\Mapper\CountryMapper;
use Sakila\Domain\Country\Repository\CountryRepository;
use Sakila\Domain\Country\Validator\CountryValidator;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;

class CountryHandlerTest extends AbstractIntegrationTestCase
{
    public function testAddCountry()
    {
        $command = new AddCountryCommand(['foo' => 'bar']);

        $validator = $this->createMock(CountryValidator::class);
        $validator->expects($this->once())->method('validate')->with($command->getAttributes());

        $mapper = new CountryMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(CountryRepository::class);
        $repository->expects($this->once())->method('add')->with($mapper->map($command->getAttributes()));
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $handler = new CountryHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleAddCountry($command));
    }

    public function testUpdateCountry()
    {
        $countryId = 1;
        $command   = new UpdateCountryCommand($countryId, ['foo' => 'bar']);

        $attributes = array_merge(['country_id' => $command->getCountryId()], $command->getAttributes());
        $validator  = $this->createMock(CountryValidator::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $mapper = new CountryMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(CountryRepository::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($command->getCountryId(), $mapper->map($command->getAttributes()))
            ->willReturn($entity);

        $handler = new CountryHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleUpdateCountry($command));
    }
}
