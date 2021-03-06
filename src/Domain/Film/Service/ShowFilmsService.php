<?php declare(strict_types=1);

namespace Sakila\Domain\Film\Service;

use Sakila\Domain\Film\Entity\Transformer\FilmTransformerInterface;
use Sakila\Domain\Film\Repository\FilmRepositoryInterface;
use Sakila\Domain\Film\Service\Request\ShowFilmsRequest;
use Sakila\Transformer\TransformerInterface;

class ShowFilmsService
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
    public function __construct(
        FilmRepositoryInterface $repository,
        TransformerInterface $transformer
    ) {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Film\Service\Request\ShowFilmsRequest $showFilmsRequest
     *
     * @return mixed
     */
    public function execute(ShowFilmsRequest $showFilmsRequest)
    {
        $page     = $showFilmsRequest->getPage();
        $pageSize = $showFilmsRequest->getPageSize();
        $films    = $this->repository->all($page, $pageSize);
        $total    = $this->repository->count();

        return $this->transformer->collection(
            $films,
            FilmTransformerInterface::class,
            $page,
            $pageSize,
            $total
        );
    }
}
