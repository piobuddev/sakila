<?php declare(strict_types=1);

namespace Sakila\Domain\Customer\Service;

use Sakila\Domain\Customer\Entity\Mapper\CustomerMapper;
use Sakila\Domain\Customer\Entity\Transformer\CustomerTransformerInterface;
use Sakila\Domain\Customer\Repository\CustomerRepository;
use Sakila\Domain\Customer\Service\Request\UpdateCustomerRequest;
use Sakila\Domain\Customer\Validator\CustomerValidator;
use Sakila\Transformer\Transformer;

class UpdateCustomerService
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
     * @param \Sakila\Domain\Customer\Service\Request\UpdateCustomerRequest $updateCustomerRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(UpdateCustomerRequest $updateCustomerRequest)
    {
        $this->validator->validate(
            array_merge(
                ['customer_id' => $updateCustomerRequest->getCustomerId()],
                $updateCustomerRequest->getAttributes()
            )
        );

        $customer = $this->customerRepository->update(
            $updateCustomerRequest->getCustomerId(),
            $this->customerMapper->map($updateCustomerRequest->getAttributes())
        );

        return $this->transformer->item($customer, CustomerTransformerInterface::class);
    }
}
