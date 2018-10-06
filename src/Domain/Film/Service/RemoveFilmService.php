<?php declare(strict_types=1);

namespace Sakila\Domain\Film\Service;

use Sakila\Domain\Film\Repository\FilmRepository;
use Sakila\Domain\Film\Service\Request\RemoveFilmRequest;

class RemoveFilmService
{
    /**
     * @var \Sakila\Domain\Film\Repository\FilmRepository
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Film\Repository\FilmRepository $repository
     */
    public function __construct(FilmRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(RemoveFilmRequest $removeFilmRequest)
    {
        return $this->repository->remove($removeFilmRequest->getFilmId());
    }
}
