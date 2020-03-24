<?php declare(strict_types=1);

namespace Sakila\Domain\Customer\Service;

use Sakila\Domain\Customer\Entity\Transformer\CustomerTransformerInterface;
use Sakila\Domain\Customer\Repository\CustomerRepositoryInterface;
use Sakila\Domain\Customer\Service\Request\ShowCustomersRequest;
use Sakila\Transformer\TransformerInterface;

class ShowCustomersService
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
    public function __construct(
        CustomerRepositoryInterface $repository,
        TransformerInterface $transformer
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
