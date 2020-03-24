<?php declare(strict_types=1);

namespace Sakila\Domain\Inventory\Service;

use Sakila\Domain\Inventory\Entity\Mapper\InventoryMapper;
use Sakila\Domain\Inventory\Entity\Transformer\InventoryTransformerInterface;
use Sakila\Domain\Inventory\Repository\InventoryRepositoryInterface;
use Sakila\Domain\Inventory\Service\Request\UpdateInventoryRequest;
use Sakila\Domain\Inventory\Validator\InventoryValidatorInterface;
use Sakila\Transformer\TransformerInterface;

class UpdateInventoryService
{
    /**
     * @var \Sakila\Domain\Inventory\Validator\InventoryValidatorInterface
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Inventory\Repository\InventoryRepositoryInterface
     */
    private $inventoryRepository;

    /**
     * @var \Sakila\Domain\Inventory\Entity\Mapper\InventoryMapper
     */
    private $inventoryMapper;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Inventory\Validator\InventoryValidatorInterface   $validator
     * @param \Sakila\Domain\Inventory\Repository\InventoryRepositoryInterface $repository
     * @param \Sakila\Domain\Inventory\Entity\Mapper\InventoryMapper           $inventoryMapper
     * @param \Sakila\Transformer\TransformerInterface                         $transformer
     */
    public function __construct(
        InventoryValidatorInterface $validator,
        InventoryRepositoryInterface $repository,
        InventoryMapper $inventoryMapper,
        TransformerInterface $transformer
    ) {
        $this->validator           = $validator;
        $this->inventoryRepository = $repository;
        $this->inventoryMapper     = $inventoryMapper;
        $this->transformer         = $transformer;
    }

    /**
     * @param \Sakila\Domain\Inventory\Service\Request\UpdateInventoryRequest $updateInventoryRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(UpdateInventoryRequest $updateInventoryRequest)
    {
        $this->validator->validate(
            array_merge(
                ['inventory_id' => $updateInventoryRequest->getInventoryId()],
                $updateInventoryRequest->getAttributes()
            )
        );

        $inventory = $this->inventoryRepository->update(
            $updateInventoryRequest->getInventoryId(),
            $this->inventoryMapper->map($updateInventoryRequest->getAttributes())
        );

        return $this->transformer->item($inventory, InventoryTransformerInterface::class);
    }
}
