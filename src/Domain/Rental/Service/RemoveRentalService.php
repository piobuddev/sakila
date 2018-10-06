<?php declare(strict_types=1);

namespace Sakila\Domain\Rental\Service;

use Sakila\Domain\Rental\Repository\RentalRepository;
use Sakila\Domain\Rental\Service\Request\RemoveRentalRequest;

class RemoveRentalService
{
    /**
     * @var \Sakila\Domain\Rental\Repository\RentalRepository
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Rental\Repository\RentalRepository $repository
     */
    public function __construct(RentalRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(RemoveRentalRequest $removeRentalRequest)
    {
        return $this->repository->remove($removeRentalRequest->getRentalId());
    }
}
