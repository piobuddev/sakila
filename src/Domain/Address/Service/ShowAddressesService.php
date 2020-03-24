<?php declare(strict_types=1);

namespace Sakila\Domain\Address\Service;

use Sakila\Domain\Address\Entity\Transformer\AddressTransformerInterface;
use Sakila\Domain\Address\Repository\AddressRepositoryInterface;
use Sakila\Domain\Address\Service\Request\ShowAddressesRequest;
use Sakila\Transformer\TransformerInterface;

class ShowAddressesService
{
    /**
     * @var \Sakila\Domain\Address\Repository\AddressRepositoryInterface
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Address\Repository\AddressRepositoryInterface $repository
     * @param \Sakila\Transformer\TransformerInterface                     $transformer
     */
    public function __construct(
        AddressRepositoryInterface $repository,
        TransformerInterface $transformer
    ) {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Address\Service\Request\ShowAddressesRequest $showAddressesRequest
     *
     * @return mixed
     */
    public function execute(ShowAddressesRequest $showAddressesRequest)
    {
        $page      = $showAddressesRequest->getPage();
        $pageSize  = $showAddressesRequest->getPageSize();
        $addresses = $this->repository->all($page, $pageSize);
        $total     = $this->repository->count();

        return $this->transformer->collection(
            $addresses,
            AddressTransformerInterface::class,
            $page,
            $pageSize,
            $total
        );
    }
}
