<?php declare(strict_types=1);

namespace Sakila\Domain\Customer\Service;

use Sakila\Domain\Customer\Entity\Mapper\CustomerMapper;
use Sakila\Domain\Customer\Entity\Transformer\CustomerTransformerInterface;
use Sakila\Domain\Customer\Repository\CustomerRepository;
use Sakila\Domain\Customer\Service\Request\AddCustomerRequest;
use Sakila\Domain\Customer\Validator\CustomerValidator;
use Sakila\Transformer\Transformer;

class AddCustomerService
{
    /**
     * @var \Sakila\Domain\Customer\Validator\CustomerValidator
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Customer\Repository\CustomerRepository
     */
    private $customerRepository;

    /**
     * @var \Sakila\Domain\Customer\Entity\Mapper\CustomerMapper
     */
    private $customerMapper;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Customer\Validator\CustomerValidator   $validator
     * @param \Sakila\Domain\Customer\Repository\CustomerRepository $repository
     * @param \Sakila\Domain\Customer\Entity\Mapper\CustomerMapper  $customerMapper
     * @param \Sakila\Transformer\Transformer                       $transformer
     */
    public function __construct(
        CustomerValidator $validator,
        CustomerRepository $repository,
        CustomerMapper $customerMapper,
        Transformer $transformer
    ) {
        $this->validator          = $validator;
        $this->customerRepository = $repository;
        $this->customerMapper     = $customerMapper;
        $this->transformer        = $transformer;
    }

    /**
     * @param \Sakila\Domain\Customer\Service\Request\AddCustomerRequest $addCustomerRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(AddCustomerRequest $addCustomerRequest)
    {
        $this->validator->validate($addCustomerRequest->getAttributes());
        $this->customerRepository->add($this->customerMapper->map($addCustomerRequest->getAttributes()));

        $customerId = $this->customerRepository->lastInsertedId();
        $customer   = $this->customerRepository->get($customerId);

        return $this->transformer->item($customer, CustomerTransformerInterface::class);
    }
}
