<?php

namespace Sakila\Test\Domain\Film\Requests\Handlers;

use Sakila\Domain\Film\Entity\Mapper\FilmMapper;
use Sakila\Domain\Film\Entity\Transformer\FilmTransformerInterface;
use Sakila\Domain\Film\Repository\FilmRepository;
use Sakila\Domain\Film\Service\AddFilmService;
use Sakila\Domain\Film\Service\Request\AddFilmRequest;
use Sakila\Domain\Film\Service\Request\UpdateFilmRequest;
use Sakila\Domain\Film\Service\UpdateFilmService;
use Sakila\Domain\Film\Validator\FilmValidator;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;
use Sakila\Transformer\Transformer;

class FilmServiceTest extends AbstractIntegrationTestCase
{
    public function testAddFilm()
    {
        $request = new AddFilmRequest(['foo' => 'bar']);

        $validator = $this->createMock(FilmValidator::class);
        $validator->expects($this->once())->method('validate')->with($request->getAttributes());

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(FilmMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(FilmRepository::class);
        $repository->expects($this->once())->method('add')->with($mapped);
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $transformer = $this->createMock(Transformer::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, FilmTransformerInterface::class)
            ->willReturn($entity);

        $service = new AddFilmService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }

    public function testUpdateFilm()
    {
        $filmId = 1;
        $request = new UpdateFilmRequest($filmId, ['foo' => 'bar']);

        $attributes = array_merge(['film_id' => $request->getFilmId()], $request->getAttributes());
        $validator  = $this->createMock(FilmValidator::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(FilmMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(FilmRepository::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($request->getFilmId(), $mapped)
            ->willReturn($entity);

        $transformer = $this->createMock(Transformer::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, FilmTransformerInterface::class)
            ->willReturn($entity);

        $service = new UpdateFilmService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }
}
