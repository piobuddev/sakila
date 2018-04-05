<?php declare(strict_types=1);

namespace Sakila\Domain\Actor\Commands\Handlers;

use Sakila\Domain\Actor\Commands\AddActorCommand;
use Sakila\Domain\Actor\Commands\UpdateActorCommand;
use Sakila\Domain\Actor\Entity\ActorEntity;
use Sakila\Domain\Actor\Entity\Mapper\ActorMapper;
use Sakila\Domain\Actor\Repository\ActorRepository;
use Sakila\Domain\Actor\Validator\ActorValidator;
use Sakila\Exceptions\UnexpectedValueException;

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
     * @throws \Sakila\Exceptions\UnexpectedValueException
     */
    public function handleAddActor(AddActorCommand $command): ActorEntity
    {
        $this->validator->validate($command->getAttributes());
        $this->actorRepository->add($this->actorMapper->map($command->getAttributes()));

        $actorId = $this->actorRepository->lastInsertedId();
        $actor   = $this->actorRepository->get($actorId);
        if (!$actor instanceof ActorEntity) {
            throw new UnexpectedValueException();
        }

        return $actor;
    }

    /**
     * @param \Sakila\Domain\Actor\Commands\UpdateActorCommand $command
     *
     * @return \Sakila\Domain\Actor\Entity\ActorEntity
     * @throws \Sakila\Exceptions\Database\NotFoundException
     * @throws \Sakila\Exceptions\InvalidArgumentException
     * @throws \Sakila\Exceptions\SakilaException
     */
    public function handleUpdateActor(UpdateActorCommand $command): ActorEntity
    {
        $attributes = array_merge(['actor_id' => $command->getActorId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->actorRepository->update(
            $command->getActorId(),
            $this->actorMapper->map($command->getAttributes())
        );
    }
}
