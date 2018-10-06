<?php declare(strict_types=1);

namespace Sakila\Domain\Customer\Service;

use Sakila\Domain\Customer\Entity\Transformer\CustomerTransformerInterface;
use Sakila\Domain\Customer\Repository\CustomerRepository;
use Sakila\Domain\Customer\Service\Request\ShowCustomersRequest;
use Sakila\Transformer\Transformer;

class ShowCustomersService
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
    public function __construct(
        CustomerRepository $repository,
        Transformer $transformer
    ) {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Customer\Service\Request\ShowCustomersRequest $showCustomersRequest
     *
     * @return mixed
     */
    public function execute(ShowCustomersRequest $showCustomersRequest)
    {
        $page      = $showCustomersRequest->getPage();
        $pageSize  = $showCustomersRequest->getPageSize();
        $customers = $this->repository->all($page, $pageSize);
        $total     = $this->repository->count();

        return $this->transformer->collection(
            $customers,
            CustomerTransformerInterface::class,
            $page,
            $pageSize,
            $total
        );
    }
}
