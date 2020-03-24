<?php declare(strict_types=1);

namespace Sakila\Domain\Film\Service;

use Sakila\Domain\Film\Entity\Transformer\FilmTransformerInterface;
use Sakila\Domain\Film\Repository\FilmRepositoryInterface;
use Sakila\Domain\Film\Service\Request\ShowFilmRequest;
use Sakila\Transformer\TransformerInterface;

class ShowFilmService
{
    /**
     * @var \Sakila\Domain\Film\Repository\FilmRepositoryInterface
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Film\Repository\FilmRepositoryInterface $repository
     * @param \Sakila\Transformer\TransformerInterface               $transformer
     */
    public function __construct(FilmRepositoryInterface $repository, TransformerInterface $transformer)
    {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Film\Service\Request\ShowFilmRequest $showFilmRequest
     *
     * @return mixed
     */
    public function execute(ShowFilmRequest $showFilmRequest)
    {
        $film = $this->repository->get($showFilmRequest->getFilmId());

        return $this->transformer->item($film, FilmTransformerInterface::class);
    }
}
