<?php declare(strict_types=1);

namespace Sakila\Domain\Store\Service;

use Sakila\Domain\Store\Entity\Mapper\StoreMapper;
use Sakila\Domain\Store\Entity\Transformer\StoreTransformerInterface;
use Sakila\Domain\Store\Repository\StoreRepositoryInterface;
use Sakila\Domain\Store\Service\Request\UpdateStoreRequest;
use Sakila\Domain\Store\Validator\StoreValidatorInterface;
use Sakila\Transformer\TransformerInterface;

class UpdateStoreService
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
