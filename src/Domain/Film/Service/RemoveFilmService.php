<?php declare(strict_types=1);

namespace Sakila\Domain\Film\Service;

use Sakila\Domain\Film\Repository\FilmRepositoryInterface;
use Sakila\Domain\Film\Service\Request\RemoveFilmRequest;

class RemoveFilmService
{
    /**
     * @var \Sakila\Domain\Film\Repository\FilmRepositoryInterface
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Film\Repository\FilmRepositoryInterface $repository
     */
    public function __construct(FilmRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Sakila\Domain\Film\Service\Request\RemoveFilmRequest $removeFilmRequest
     *
     * @return bool
     */
    public function execute(RemoveFilmRequest $removeFilmRequest): bool
    {
        return $this->repository->remove($removeFilmRequest->getFilmId());
    }
}
