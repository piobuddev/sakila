<?php declare(strict_types=1);

namespace Sakila\Domain\Customer\Service;

use Sakila\Domain\Customer\Repository\CustomerRepositoryInterface;
use Sakila\Domain\Customer\Service\Request\RemoveCustomerRequest;

class RemoveCustomerService
{
    /**
     * @var \Sakila\Domain\Customer\Repository\CustomerRepositoryInterface
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Customer\Repository\CustomerRepositoryInterface $repository
     */
    public function __construct(CustomerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Sakila\Domain\Customer\Service\Request\RemoveCustomerRequest $removeCustomerRequest
     *
     * @return bool
     */
    public function execute(RemoveCustomerRequest $removeCustomerRequest): bool
    {
        return $this->repository->remove($removeCustomerRequest->getCustomerId());
    }
}
