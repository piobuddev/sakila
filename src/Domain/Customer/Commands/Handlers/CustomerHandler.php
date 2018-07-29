<?php declare(strict_types=1);

namespace Sakila\Domain\Customer\Commands\Handlers;

use Sakila\Domain\Customer\Commands\AddCustomerCommand;
use Sakila\Domain\Customer\Commands\UpdateCustomerCommand;
use Sakila\Domain\Customer\Entity\Mapper\CustomerMapper;
use Sakila\Domain\Customer\Repository\CustomerRepository;
use Sakila\Domain\Customer\Validator\CustomerValidator;
use Sakila\Entity\EntityInterface;

class CustomerHandler
{
    /**
     * @var \Sakila\Domain\Customer\Entity\Mapper\CustomerMapper
     */
    private $customerMapper;

    /**
     * @var \Sakila\Domain\Customer\Repository\CustomerRepository
     */
    private $customerRepository;

    /**
     * @var \Sakila\Domain\Customer\Validator\CustomerValidator
     */
    private $validator;

    /**
     * @param \Sakila\Domain\Customer\Entity\Mapper\CustomerMapper  $mapper
     * @param \Sakila\Domain\Customer\Repository\CustomerRepository $repository
     * @param \Sakila\Domain\Customer\Validator\CustomerValidator   $validator
     */
    public function __construct(CustomerMapper $mapper, CustomerRepository $repository, CustomerValidator $validator)
    {
        $this->customerMapper     = $mapper;
        $this->customerRepository = $repository;
        $this->validator          = $validator;
    }

    /**
     * @param \Sakila\Domain\Customer\Commands\AddCustomerCommand $command
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function handleAddCustomer(AddCustomerCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->customerRepository->add($this->customerMapper->map($command->getAttributes()));

        $customerId = $this->customerRepository->lastInsertedId();
        $customer   = $this->customerRepository->get($customerId);

        return $customer;
    }


    /**
     * @param \Sakila\Domain\Customer\Commands\UpdateCustomerCommand $command
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function handleUpdateCustomer(UpdateCustomerCommand $command): EntityInterface
    {
        $attributes = array_merge(['customer_id' => $command->getCustomerId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->customerRepository->update(
            $command->getCustomerId(),
            $this->customerMapper->map($command->getAttributes())
        );
    }
}
