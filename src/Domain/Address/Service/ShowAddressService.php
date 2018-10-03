<?php declare(strict_types=1);

namespace Sakila\Domain\Address\Service;

use Sakila\Domain\Address\Entity\Transformer\AddressTransformerInterface;
use Sakila\Domain\Address\Repository\AddressRepository;
use Sakila\Domain\Address\Service\Request\ShowAddressRequest;
use Sakila\Transformer\Transformer;

class ShowAddressService
{
    /**
     * @var \Sakila\Domain\Address\Repository\AddressRepository
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Address\Repository\AddressRepository $repository
     * @param \Sakila\Transformer\Transformer                     $transformer
     */
    public function __construct(AddressRepository $repository, Transformer $transformer)
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
