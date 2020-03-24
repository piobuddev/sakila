<?php declare(strict_types=1);

namespace Sakila\Domain\Actor\Service;

use Sakila\Domain\Actor\Entity\Mapper\ActorMapper;
use Sakila\Domain\Actor\Entity\Transformer\ActorTransformerInterface;
use Sakila\Domain\Actor\Repository\ActorRepositoryInterface;
use Sakila\Domain\Actor\Service\Request\UpdateActorRequest;
use Sakila\Domain\Actor\Validator\ActorValidatorInterface;
use Sakila\Transformer\TransformerInterface;

class UpdateActorService
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
     * @param \Sakila\Domain\Actor\Service\Request\UpdateActorRequest $updateActorRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(UpdateActorRequest $updateActorRequest)
    {
        $this->validator->validate(
            array_merge(
                ['actor_id' => $updateActorRequest->getActorId()],
                $updateActorRequest->getAttributes()
            )
        );

        $actor = $this->actorRepository->update(
            $updateActorRequest->getActorId(),
            $this->actorMapper->map($updateActorRequest->getAttributes())
        );

        return $this->transformer->item($actor, ActorTransformerInterface::class);
    }
}
