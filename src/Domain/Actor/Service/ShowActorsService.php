<?php declare(strict_types=1);

namespace Sakila\Domain\Actor\Service;

use Sakila\Domain\Actor\Entity\Transformer\ActorTransformerInterface;
use Sakila\Domain\Actor\Repository\ActorRepositoryInterface;
use Sakila\Domain\Actor\Service\Request\ShowActorsRequest;
use Sakila\Transformer\TransformerInterface;

class ShowActorsService
{
    /**
     * @var \Sakila\Domain\Actor\Repository\ActorRepositoryInterface
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Actor\Repository\ActorRepositoryInterface $repository
     * @param \Sakila\Transformer\TransformerInterface                 $transformer
     */
    public function __construct(
        ActorRepositoryInterface $repository,
        TransformerInterface $transformer
    ) {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Actor\Service\Request\ShowActorsRequest $showActorsRequest
     *
     * @return mixed
     */
    public function execute(ShowActorsRequest $showActorsRequest)
    {
        $page     = $showActorsRequest->getPage();
        $pageSize = $showActorsRequest->getPageSize();
        $actors   = $this->repository->all($page, $pageSize);
        $total    = $this->repository->count();

        return $this->transformer->collection(
            $actors,
            ActorTransformerInterface::class,
            $page,
            $pageSize,
            $total
        );
    }
}
