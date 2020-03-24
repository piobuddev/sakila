<?php declare(strict_types=1);

namespace Sakila\Domain\Address\Service;

use Sakila\Domain\Address\Entity\Transformer\AddressTransformerInterface;
use Sakila\Domain\Address\Repository\AddressRepositoryInterface;
use Sakila\Domain\Address\Service\Request\ShowAddressRequest;
use Sakila\Transformer\TransformerInterface;

class ShowAddressService
{
    /**
     * @var \Sakila\Domain\Address\Repository\AddressRepositoryInterface
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Address\Repository\AddressRepositoryInterface $repository
     * @param \Sakila\Transformer\TransformerInterface                     $transformer
     */
    public function __construct(AddressRepositoryInterface $repository, TransformerInterface $transformer)
    {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Address\Service\Request\ShowAddressRequest $showAddressRequest
     *
     * @return mixed
     */
    public function execute(ShowAddressRequest $showAddressRequest)
    {
        $address = $this->repository->get($showAddressRequest->getAddressId());

        return $this->transformer->item($address, AddressTransformerInterface::class);
    }
}
