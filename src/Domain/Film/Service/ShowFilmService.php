<?php declare(strict_types=1);

namespace Sakila\Domain\Film\Service;

use Sakila\Domain\Film\Entity\Transformer\FilmTransformerInterface;
use Sakila\Domain\Film\Repository\FilmRepository;
use Sakila\Domain\Film\Service\Request\ShowFilmRequest;
use Sakila\Transformer\Transformer;

class ShowFilmService
{
    /**
     * @var \Sakila\Domain\Film\Repository\FilmRepository
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Film\Repository\FilmRepository $repository
     * @param \Sakila\Transformer\Transformer               $transformer
     */
    public function __construct(FilmRepository $repository, Transformer $transformer)
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
