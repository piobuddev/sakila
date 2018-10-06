<?php declare(strict_types=1);

namespace Sakila\Domain\Customer\Service;

use Sakila\Domain\Customer\Entity\Transformer\CustomerTransformerInterface;
use Sakila\Domain\Customer\Repository\CustomerRepository;
use Sakila\Domain\Customer\Service\Request\ShowCustomerRequest;
use Sakila\Transformer\Transformer;

class ShowCustomerService
{
    /**
     * @var \Sakila\Domain\Customer\Repository\CustomerRepository
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Customer\Repository\CustomerRepository $repository
     * @param \Sakila\Transformer\Transformer                       $transformer
     */
    public function __construct(CustomerRepository $repository, Transformer $transformer)
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
