<?php declare(strict_types=1);

namespace Sakila\Domain\Address\Service;

use Sakila\Domain\Address\Repository\AddressRepository;
use Sakila\Domain\Address\Service\Request\RemoveAddressRequest;

class RemoveAddressService
{
    /**
     * @var \Sakila\Domain\Address\Repository\AddressRepository
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Address\Repository\AddressRepository $repository
     */
    public function __construct(AddressRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Sakila\Domain\Address\Service\Request\RemoveAddressRequest $removeAddressRequest
     *
     * @return bool
     */
    public function execute(RemoveAddressRequest $removeAddressRequest): bool
    {
        return $this->repository->remove($removeAddressRequest->getAddressId());
    }
}
