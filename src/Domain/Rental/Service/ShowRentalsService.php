<?php declare(strict_types=1);

namespace Sakila\Domain\Rental\Service;

use Sakila\Domain\Rental\Entity\Transformer\RentalTransformerInterface;
use Sakila\Domain\Rental\Repository\RentalRepositoryInterface;
use Sakila\Domain\Rental\Service\Request\ShowRentalsRequest;
use Sakila\Transformer\TransformerInterface;

class ShowRentalsService
{
    /**
     * @var \Sakila\Domain\Rental\Repository\RentalRepositoryInterface
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Rental\Repository\RentalRepositoryInterface $repository
     * @param \Sakila\Transformer\TransformerInterface                   $transformer
     */
    public function __construct(
        RentalRepositoryInterface $repository,
        TransformerInterface $transformer
    ) {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Rental\Service\Request\ShowRentalsRequest $showRentalsRequest
     *
     * @return mixed
     */
    public function execute(ShowRentalsRequest $showRentalsRequest)
    {
        $page     = $showRentalsRequest->getPage();
        $pageSize = $showRentalsRequest->getPageSize();
        $rentals  = $this->repository->all($page, $pageSize);
        $total    = $this->repository->count();

        return $this->transformer->collection(
            $rentals,
            RentalTransformerInterface::class,
            $page,
            $pageSize,
            $total
        );
    }
}
