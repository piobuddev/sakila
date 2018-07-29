<?php declare(strict_types=1);

namespace Sakila\Domain\Film\Commands\Handlers;

use Sakila\Domain\Film\Commands\AddFilmCommand;
use Sakila\Domain\Film\Commands\UpdateFilmCommand;
use Sakila\Domain\Film\Entity\Mapper\FilmMapper;
use Sakila\Domain\Film\Repository\FilmRepository;
use Sakila\Domain\Film\Validator\FilmValidator;
use Sakila\Entity\EntityInterface;

class FilmHandler
{
    /**
     * @var \Sakila\Domain\Film\Entity\Mapper\FilmMapper
     */
    private $filmMapper;

    /**
     * @var \Sakila\Domain\Film\Repository\FilmRepository
     */
    private $filmRepository;

    /**
     * @var \Sakila\Domain\Film\Validator\FilmValidator
     */
    private $validator;

    /**
     * @param \Sakila\Domain\Film\Entity\Mapper\FilmMapper  $mapper
     * @param \Sakila\Domain\Film\Repository\FilmRepository $repository
     * @param \Sakila\Domain\Film\Validator\FilmValidator   $validator
     */
    public function __construct(FilmMapper $mapper, FilmRepository $repository, FilmValidator $validator)
    {
        $this->filmMapper     = $mapper;
        $this->filmRepository = $repository;
        $this->validator      = $validator;
    }

    /**
     * @param \Sakila\Domain\Film\Commands\AddFilmCommand $command
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function handleAddFilm(AddFilmCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->filmRepository->add($this->filmMapper->map($command->getAttributes()));

        $filmId = $this->filmRepository->lastInsertedId();
        $film   = $this->filmRepository->get($filmId);

        return $film;
    }


    /**
     * @param \Sakila\Domain\Film\Commands\UpdateFilmCommand $command
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function handleUpdateFilm(UpdateFilmCommand $command): EntityInterface
    {
        $attributes = array_merge(['film_id' => $command->getFilmId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->filmRepository->update(
            $command->getFilmId(),
            $this->filmMapper->map($command->getAttributes())
        );
    }
}
