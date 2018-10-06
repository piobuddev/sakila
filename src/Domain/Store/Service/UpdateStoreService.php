<?php declare(strict_types=1);

namespace Sakila\Domain\Store\Service;

use Sakila\Domain\Store\Entity\Mapper\StoreMapper;
use Sakila\Domain\Store\Entity\Transformer\StoreTransformerInterface;
use Sakila\Domain\Store\Repository\StoreRepository;
use Sakila\Domain\Store\Service\Request\UpdateStoreRequest;
use Sakila\Domain\Store\Validator\StoreValidator;
use Sakila\Transformer\Transformer;

class UpdateStoreService
{
    /**
     * @var \Sakila\Domain\Store\Validator\StoreValidator
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Store\Repository\StoreRepository
     */
    private $storeRepository;

    /**
     * @var \Sakila\Domain\Store\Entity\Mapper\StoreMapper
     */
    private $storeMapper;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Store\Validator\StoreValidator   $validator
     * @param \Sakila\Domain\Store\Repository\StoreRepository $repository
     * @param \Sakila\Domain\Store\Entity\Mapper\StoreMapper  $storeMapper
     * @param \Sakila\Transformer\Transformer                 $transformer
     */
    public function __construct(
        StoreValidator $validator,
        StoreRepository $repository,
        StoreMapper $storeMapper,
        Transformer $transformer
    ) {
        $this->validator       = $validator;
        $this->storeRepository = $repository;
        $this->storeMapper     = $storeMapper;
        $this->transformer     = $transformer;
    }

    /**
     * @param \Sakila\Domain\Store\Service\Request\UpdateStoreRequest $updateStoreRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(UpdateStoreRequest $updateStoreRequest)
    {
        $this->validator->validate(
            array_merge(
                ['store_id' => $updateStoreRequest->getStoreId()],
                $updateStoreRequest->getAttributes()
            )
        );

        $store = $this->storeRepository->update(
            $updateStoreRequest->getStoreId(),
            $this->storeMapper->map($updateStoreRequest->getAttributes())
        );

        return $this->transformer->item($store, StoreTransformerInterface::class);
    }
}
