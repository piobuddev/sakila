<?php declare(strict_types=1);

namespace Sakila\Domain\Actor\Service;

use Sakila\Domain\Actor\Entity\Mapper\ActorMapper;
use Sakila\Domain\Actor\Entity\Transformer\ActorTransformerInterface;
use Sakila\Domain\Actor\Repository\ActorRepositoryInterface;
use Sakila\Domain\Actor\Service\Request\AddActorRequest;
use Sakila\Domain\Actor\Validator\ActorValidatorInterface;
use Sakila\Transformer\TransformerInterface;

class AddActorService
{
    /**
     * @var \Sakila\Domain\Actor\Validator\ActorValidatorInterface
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Actor\Repository\ActorRepositoryInterface
     */
    private $actorRepository;

    /**
     * @var \Sakila\Domain\Actor\Entity\Mapper\ActorMapper
     */
    private $actorMapper;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Actor\Validator\ActorValidatorInterface   $validator
     * @param \Sakila\Domain\Actor\Repository\ActorRepositoryInterface $repository
     * @param \Sakila\Domain\Actor\Entity\Mapper\ActorMapper           $actorMapper
     * @param \Sakila\Transformer\TransformerInterface                 $transformer
     */
    public function __construct(
        ActorValidatorInterface $validator,
        ActorRepositoryInterface $repository,
        ActorMapper $actorMapper,
        TransformerInterface $transformer
    ) {
        $this->validator       = $validator;
        $this->actorRepository = $repository;
        $this->actorMapper     = $actorMapper;
        $this->transformer     = $transformer;
    }

    /**
     * @param \Sakila\Domain\Actor\Service\Request\AddActorRequest $addActorRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(AddActorRequest $addActorRequest)
    {
        $this->validator->validate($addActorRequest->getAttributes());
        $this->actorRepository->add($this->actorMapper->map($addActorRequest->getAttributes()));

        $actorId = $this->actorRepository->lastInsertedId();
        $actor   = $this->actorRepository->get($actorId);

        return $this->transformer->item($actor, ActorTransformerInterface::class);
    }
}
