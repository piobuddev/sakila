<?php declare(strict_types=1);

namespace Sakila\Domain\Rental\Service;

use Sakila\Domain\Rental\Entity\Transformer\RentalTransformerInterface;
use Sakila\Domain\Rental\Repository\RentalRepositoryInterface;
use Sakila\Domain\Rental\Service\Request\ShowRentalRequest;
use Sakila\Transformer\TransformerInterface;

class ShowRentalService
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
    public function __construct(RentalRepositoryInterface $repository, TransformerInterface $transformer)
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
