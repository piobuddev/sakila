<?php declare(strict_types=1);

namespace Sakila\Domain\Actor\Commands\Handlers;

use Sakila\Domain\Actor\Commands\AddActorCommand;
use Sakila\Domain\Actor\Commands\UpdateActorCommand;
use Sakila\Domain\Actor\Entity\Mapper\ActorMapper;
use Sakila\Domain\Actor\Repository\ActorRepository;
use Sakila\Domain\Actor\Validator\ActorValidator;
use Sakila\Entity\EntityInterface;

class ActorHandler
{
    /**
     * @var \Sakila\Domain\Actor\Entity\Mapper\ActorMapper
     */
    private $actorMapper;

    /**
     * @var \Sakila\Domain\Actor\Repository\ActorRepository
     */
    private $actorRepository;

    /**
     * @var \Sakila\Domain\Actor\Validator\ActorValidator
     */
    private $validator;

    /**
     * @param \Sakila\Domain\Actor\Entity\Mapper\ActorMapper  $mapper
     * @param \Sakila\Domain\Actor\Repository\ActorRepository $repository
     * @param \Sakila\Domain\Actor\Validator\ActorValidator   $validator
     */
    public function __construct(ActorMapper $mapper, ActorRepository $repository, ActorValidator $validator)
    {
        $this->actorMapper     = $mapper;
        $this->actorRepository = $repository;
        $this->validator       = $validator;
    }

    /**
     * @param \Sakila\Domain\Actor\Commands\AddActorCommand $command
     *
     * @return \Sakila\Domain\Actor\Entity\ActorEntity
     */
    public function handleAddActor(AddActorCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->actorRepository->add($this->actorMapper->map($command->getAttributes()));

        $actorId = $this->actorRepository->lastInsertedId();
        $actor   = $this->actorRepository->get($actorId);

        return $actor;
    }

    /**
     * @param \Sakila\Domain\Actor\Commands\UpdateActorCommand $command
     *
     * @return \Sakila\Domain\Actor\Entity\ActorEntity
     */
    public function handleUpdateActor(UpdateActorCommand $command): EntityInterface
    {
        $attributes = array_merge(['actor_id' => $command->getActorId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->actorRepository->update(
            $command->getActorId(),
            $this->actorMapper->map($command->getAttributes())
        );
    }
}
