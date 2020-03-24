<?php declare(strict_types=1);

namespace Sakila\Domain\Store\Service;

use Sakila\Domain\Store\Entity\Mapper\StoreMapper;
use Sakila\Domain\Store\Entity\Transformer\StoreTransformerInterface;
use Sakila\Domain\Store\Repository\StoreRepositoryInterface;
use Sakila\Domain\Store\Service\Request\AddStoreRequest;
use Sakila\Domain\Store\Validator\StoreValidatorInterface;
use Sakila\Transformer\TransformerInterface;

class AddStoreService
{
    /**
     * @var \Sakila\Domain\Store\Validator\StoreValidatorInterface
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Store\Repository\StoreRepositoryInterface
     */
    private $storeRepository;

    /**
     * @var \Sakila\Domain\Store\Entity\Mapper\StoreMapper
     */
    private $storeMapper;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Store\Validator\StoreValidatorInterface   $validator
     * @param \Sakila\Domain\Store\Repository\StoreRepositoryInterface $repository
     * @param \Sakila\Domain\Store\Entity\Mapper\StoreMapper           $storeMapper
     * @param \Sakila\Transformer\TransformerInterface                 $transformer
     */
    public function __construct(
        StoreValidatorInterface $validator,
        StoreRepositoryInterface $repository,
        StoreMapper $storeMapper,
        TransformerInterface $transformer
    ) {
        $this->validator       = $validator;
        $this->storeRepository = $repository;
        $this->storeMapper     = $storeMapper;
        $this->transformer     = $transformer;
    }

    /**
     * @param \Sakila\Domain\Store\Service\Request\AddStoreRequest $addStoreRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(AddStoreRequest $addStoreRequest)
    {
        $this->validator->validate($addStoreRequest->getAttributes());
        $this->storeRepository->add($this->storeMapper->map($addStoreRequest->getAttributes()));

        $storeId = $this->storeRepository->lastInsertedId();
        $store   = $this->storeRepository->get($storeId);

        return $this->transformer->item($store, StoreTransformerInterface::class);
    }
}
