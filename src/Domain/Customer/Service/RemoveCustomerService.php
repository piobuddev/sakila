<?php declare(strict_types=1);

namespace Sakila\Domain\Customer\Service;

use Sakila\Domain\Customer\Repository\CustomerRepository;
use Sakila\Domain\Customer\Service\Request\RemoveCustomerRequest;

class RemoveCustomerService
{
    /**
     * @var \Sakila\Domain\Customer\Repository\CustomerRepository
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Customer\Repository\CustomerRepository $repository
     */
    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(RemoveCustomerRequest $removeCustomerRequest)
    {
        return $this->repository->remove($removeCustomerRequest->getCustomerId());
    }
}