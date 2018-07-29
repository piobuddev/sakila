<?php

namespace Sakila\Test\Domain\Film\Commands\Handlers;

use Sakila\Domain\Film\Commands\AddFilmCommand;
use Sakila\Domain\Film\Commands\Handlers\FilmHandler;
use Sakila\Domain\Film\Commands\UpdateFilmCommand;
use Sakila\Domain\Film\Entity\Mapper\FilmMapper;
use Sakila\Domain\Film\Repository\FilmRepository;
use Sakila\Domain\Film\Validator\FilmValidator;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;

class FilmHandlerTest extends AbstractIntegrationTestCase
{
    public function testAddFilm()
    {
        $command = new AddFilmCommand(['foo' => 'bar']);

        $validator = $this->createMock(FilmValidator::class);
        $validator->expects($this->once())->method('validate')->with($command->getAttributes());

        $mapper = new FilmMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(FilmRepository::class);
        $repository->expects($this->once())->method('add')->with($mapper->map($command->getAttributes()));
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $handler = new FilmHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleAddFilm($command));
    }

    public function testUpdateFilm()
    {
        $filmId  = 1;
        $command = new UpdateFilmCommand($filmId, ['foo' => 'bar']);

        $attributes = array_merge(['film_id' => $command->getFilmId()], $command->getAttributes());
        $validator  = $this->createMock(FilmValidator::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $mapper = new FilmMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(FilmRepository::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($command->getFilmId(), $mapper->map($command->getAttributes()))
            ->willReturn($entity);

        $handler = new FilmHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleUpdateFilm($command));
    }
}
