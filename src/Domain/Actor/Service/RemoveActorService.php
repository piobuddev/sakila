<?php declare(strict_types=1);

namespace Sakila\Domain\Actor\Service;

use Sakila\Domain\Actor\Repository\ActorRepository;
use Sakila\Domain\Actor\Service\Request\RemoveActorRequest;

class RemoveActorService
{
    /**
     * @var \Sakila\Domain\Actor\Repository\ActorRepository
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Actor\Repository\ActorRepository $repository
     */
    public function __construct(ActorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Sakila\Domain\Actor\Service\Request\RemoveActorRequest $removeActorRequest
     *
     * @return bool
     */
    public function execute(RemoveActorRequest $removeActorRequest): bool
    {
        return $this->repository->remove($removeActorRequest->getActorId());
    }
}
