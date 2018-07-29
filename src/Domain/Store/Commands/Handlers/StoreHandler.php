<?php declare(strict_types=1);

namespace Sakila\Domain\Store\Commands\Handlers;

use Sakila\Domain\Store\Commands\AddStoreCommand;
use Sakila\Domain\Store\Commands\UpdateStoreCommand;
use Sakila\Domain\Store\Entity\Mapper\StoreMapper;
use Sakila\Domain\Store\Repository\StoreRepository;
use Sakila\Domain\Store\Validator\StoreValidator;
use Sakila\Entity\EntityInterface;

class StoreHandler
{
    /**
     * @var \Sakila\Domain\Store\Entity\Mapper\StoreMapper
     */
    private $storeMapper;

    /**
     * @var \Sakila\Domain\Store\Repository\StoreRepository
     */
    private $storeRepository;

    /**
     * @var \Sakila\Domain\Store\Validator\StoreValidator
     */
    private $validator;

    /**
     * @param \Sakila\Domain\Store\Entity\Mapper\StoreMapper  $mapper
     * @param \Sakila\Domain\Store\Repository\StoreRepository $repository
     * @param \Sakila\Domain\Store\Validator\StoreValidator   $validator
     */
    public function __construct(StoreMapper $mapper, StoreRepository $repository, StoreValidator $validator)
    {
        $this->storeMapper     = $mapper;
        $this->storeRepository = $repository;
        $this->validator       = $validator;
    }

    /**
     * @param \Sakila\Domain\Store\Commands\AddStoreCommand $command
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function handleAddStore(AddStoreCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->storeRepository->add($this->storeMapper->map($command->getAttributes()));

        $storeId = $this->storeRepository->lastInsertedId();
        $store   = $this->storeRepository->get($storeId);

        return $store;
    }


    /**
     * @param \Sakila\Domain\Store\Commands\UpdateStoreCommand $command
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function handleUpdateStore(UpdateStoreCommand $command): EntityInterface
    {
        $attributes = array_merge(['store_id' => $command->getStoreId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->storeRepository->update(
            $command->getStoreId(),
            $this->storeMapper->map($command->getAttributes())
        );
    }
}
