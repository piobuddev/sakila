<?php declare(strict_types=1);

namespace Sakila\Domain\Address\Service;

use Sakila\Domain\Address\Entity\Transformer\AddressTransformerInterface;
use Sakila\Domain\Address\Repository\AddressRepository;
use Sakila\Domain\Address\Service\Request\ShowAddressesRequest;
use Sakila\Transformer\Transformer;

class ShowAddressesService
{
    /**
     * @var \Sakila\Domain\Address\Repository\AddressRepository
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Address\Repository\AddressRepository $repository
     * @param \Sakila\Transformer\Transformer                     $transformer
     */
    public function __construct(
        AddressRepository $repository,
        Transformer $transformer
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
