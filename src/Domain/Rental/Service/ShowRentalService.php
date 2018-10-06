<?php declare(strict_types=1);

namespace Sakila\Domain\Rental\Service;

use Sakila\Domain\Rental\Entity\Transformer\RentalTransformerInterface;
use Sakila\Domain\Rental\Repository\RentalRepository;
use Sakila\Domain\Rental\Service\Request\ShowRentalRequest;
use Sakila\Transformer\Transformer;

class ShowRentalService
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
    public function __construct(RentalRepository $repository, Transformer $transformer)
    {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Rental\Service\Request\ShowRentalRequest $showRentalRequest
     *
     * @return mixed
     */
    public function execute(ShowRentalRequest $showRentalRequest)
    {
        $rental = $this->repository->get($showRentalRequest->getRentalId());

        return $this->transformer->item($rental, RentalTransformerInterface::class);
    }
}
