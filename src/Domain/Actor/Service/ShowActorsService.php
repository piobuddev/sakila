<?php declare(strict_types=1);

namespace Sakila\Domain\Actor\Service;

use Sakila\Domain\Actor\Entity\Transformer\ActorTransformerInterface;
use Sakila\Domain\Actor\Repository\ActorRepository;
use Sakila\Domain\Actor\Service\Request\ShowActorsRequest;
use Sakila\Transformer\Transformer;

class ShowActorsService
{
    /**
     * @var \Sakila\Domain\Actor\Repository\ActorRepository
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Actor\Repository\ActorRepository $repository
     * @param \Sakila\Transformer\Transformer                 $transformer
     */
    public function __construct(
        ActorRepository $repository,
        Transformer $transformer
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
