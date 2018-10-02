<?php declare(strict_types=1);

namespace Sakila\Domain\Actor\Service;

use Sakila\Domain\Actor\Entity\Mapper\ActorMapper;
use Sakila\Domain\Actor\Entity\Transformer\ActorTransformerInterface;
use Sakila\Domain\Actor\Repository\ActorRepository;
use Sakila\Domain\Actor\Service\Request\AddActorRequest;
use Sakila\Domain\Actor\Validator\ActorValidator;
use Sakila\Transformer\Transformer;

class AddActorService
{
    /**
     * @var \Sakila\Domain\Actor\Validator\ActorValidator
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Actor\Repository\ActorRepository
     */
    private $actorRepository;

    /**
     * @var \Sakila\Domain\Actor\Entity\Mapper\ActorMapper
     */
    private $actorMapper;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Actor\Validator\ActorValidator   $validator
     * @param \Sakila\Domain\Actor\Repository\ActorRepository $repository
     * @param \Sakila\Domain\Actor\Entity\Mapper\ActorMapper  $actorMapper
     * @param \Sakila\Transformer\Transformer                 $transformer
     */
    public function __construct(
        ActorValidator $validator,
        ActorRepository $repository,
        ActorMapper $actorMapper,
        Transformer $transformer
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
