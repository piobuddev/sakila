<?php declare(strict_types=1);

namespace Sakila\Domain\Customer\Service;

use Sakila\Domain\Customer\Entity\Mapper\CustomerMapper;
use Sakila\Domain\Customer\Entity\Transformer\CustomerTransformerInterface;
use Sakila\Domain\Customer\Repository\CustomerRepositoryInterface;
use Sakila\Domain\Customer\Service\Request\UpdateCustomerRequest;
use Sakila\Domain\Customer\Validator\CustomerValidatorInterface;
use Sakila\Transformer\TransformerInterface;

class UpdateCustomerService
{
    /**
     * @var \Sakila\Domain\Customer\Validator\CustomerValidatorInterface
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Customer\Repository\CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var \Sakila\Domain\Customer\Entity\Mapper\CustomerMapper
     */
    private $customerMapper;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Customer\Validator\CustomerValidatorInterface   $validator
     * @param \Sakila\Domain\Customer\Repository\CustomerRepositoryInterface $repository
     * @param \Sakila\Domain\Customer\Entity\Mapper\CustomerMapper           $customerMapper
     * @param \Sakila\Transformer\TransformerInterface                       $transformer
     */
    public function __construct(
        CustomerValidatorInterface $validator,
        CustomerRepositoryInterface $repository,
        CustomerMapper $customerMapper,
        TransformerInterface $transformer
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
