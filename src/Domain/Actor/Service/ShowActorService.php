<?php declare(strict_types=1);

namespace Sakila\Domain\Actor\Service;

use Sakila\Domain\Actor\Entity\Transformer\ActorTransformerInterface;
use Sakila\Domain\Actor\Repository\ActorRepositoryInterface;
use Sakila\Domain\Actor\Service\Request\ShowActorRequest;
use Sakila\Transformer\TransformerInterface;

class ShowActorService
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
    public function __construct(ActorRepositoryInterface $repository, TransformerInterface $transformer)
    {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Actor\Service\Request\ShowActorRequest $showActorRequest
     *
     * @return mixed
     */
    public function execute(ShowActorRequest $showActorRequest)
    {
        $actor = $this->repository->get($showActorRequest->getActorId());

        return $this->transformer->item($actor, ActorTransformerInterface::class);
    }
}
