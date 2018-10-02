<?php declare(strict_types=1);

namespace Sakila\Domain\Actor\Service;

use Sakila\Domain\Actor\Entity\Transformer\ActorTransformerInterface;
use Sakila\Domain\Actor\Repository\ActorRepository;
use Sakila\Domain\Actor\Service\Request\ShowActorRequest;
use Sakila\Transformer\Transformer;

class ShowActorService
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
    public function __construct(ActorRepository $repository, Transformer $transformer)
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
