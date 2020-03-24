<?php declare(strict_types=1);

namespace Sakila\Domain\Inventory\Service;

use Sakila\Domain\Inventory\Entity\Mapper\InventoryMapper;
use Sakila\Domain\Inventory\Entity\Transformer\InventoryTransformerInterface;
use Sakila\Domain\Inventory\Repository\InventoryRepositoryInterface;
use Sakila\Domain\Inventory\Service\Request\AddInventoryRequest;
use Sakila\Domain\Inventory\Validator\InventoryValidatorInterface;
use Sakila\Transformer\TransformerInterface;

class AddInventoryService
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
     * @param \Sakila\Domain\Inventory\Service\Request\AddInventoryRequest $addInventoryRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(AddInventoryRequest $addInventoryRequest)
    {
        $this->validator->validate($addInventoryRequest->getAttributes());
        $this->inventoryRepository->add($this->inventoryMapper->map($addInventoryRequest->getAttributes()));

        $inventoryId = $this->inventoryRepository->lastInsertedId();
        $inventory   = $this->inventoryRepository->get($inventoryId);

        return $this->transformer->item($inventory, InventoryTransformerInterface::class);
    }
}
