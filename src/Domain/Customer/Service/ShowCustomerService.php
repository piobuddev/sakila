<?php declare(strict_types=1);

namespace Sakila\Domain\Customer\Service;

use Sakila\Domain\Customer\Entity\Transformer\CustomerTransformerInterface;
use Sakila\Domain\Customer\Repository\CustomerRepositoryInterface;
use Sakila\Domain\Customer\Service\Request\ShowCustomerRequest;
use Sakila\Transformer\TransformerInterface;

class ShowCustomerService
{
    /**
     * @var \Sakila\Domain\Customer\Repository\CustomerRepositoryInterface
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Customer\Repository\CustomerRepositoryInterface $repository
     * @param \Sakila\Transformer\TransformerInterface                       $transformer
     */
    public function __construct(CustomerRepositoryInterface $repository, TransformerInterface $transformer)
    {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Customer\Service\Request\ShowCustomerRequest $showCustomerRequest
     *
     * @return mixed
     */
    public function execute(ShowCustomerRequest $showCustomerRequest)
    {
        $customer = $this->repository->get($showCustomerRequest->getCustomerId());

        return $this->transformer->item($customer, CustomerTransformerInterface::class);
    }
}
