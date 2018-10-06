<?php declare(strict_types=1);

namespace Sakila\Domain\Rental\Service;

use Sakila\Domain\Rental\Entity\Transformer\RentalTransformerInterface;
use Sakila\Domain\Rental\Repository\RentalRepository;
use Sakila\Domain\Rental\Service\Request\ShowRentalsRequest;
use Sakila\Transformer\Transformer;

class ShowRentalsService
{
    /**
     * @var \Sakila\Domain\Rental\Repository\RentalRepository
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Rental\Repository\RentalRepository $repository
     * @param \Sakila\Transformer\Transformer                   $transformer
     */
    public function __construct(
        RentalRepository $repository,
        Transformer $transformer
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
