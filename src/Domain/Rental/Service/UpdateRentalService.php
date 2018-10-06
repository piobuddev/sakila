<?php declare(strict_types=1);

namespace Sakila\Domain\Rental\Service;

use Sakila\Domain\Rental\Entity\Mapper\RentalMapper;
use Sakila\Domain\Rental\Entity\Transformer\RentalTransformerInterface;
use Sakila\Domain\Rental\Repository\RentalRepository;
use Sakila\Domain\Rental\Service\Request\UpdateRentalRequest;
use Sakila\Domain\Rental\Validator\RentalValidator;
use Sakila\Transformer\Transformer;

class UpdateRentalService
{
    /**
     * @var \Sakila\Domain\Rental\Validator\RentalValidator
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Rental\Repository\RentalRepository
     */
    private $rentalRepository;

    /**
     * @var \Sakila\Domain\Rental\Entity\Mapper\RentalMapper
     */
    private $rentalMapper;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Rental\Validator\RentalValidator   $validator
     * @param \Sakila\Domain\Rental\Repository\RentalRepository $repository
     * @param \Sakila\Domain\Rental\Entity\Mapper\RentalMapper  $rentalMapper
     * @param \Sakila\Transformer\Transformer                   $transformer
     */
    public function __construct(
        RentalValidator $validator,
        RentalRepository $repository,
        RentalMapper $rentalMapper,
        Transformer $transformer
    ) {
        $this->validator        = $validator;
        $this->rentalRepository = $repository;
        $this->rentalMapper     = $rentalMapper;
        $this->transformer      = $transformer;
    }

    /**
     * @param \Sakila\Domain\Rental\Service\Request\UpdateRentalRequest $updateRentalRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(UpdateRentalRequest $updateRentalRequest)
    {
        $this->validator->validate(
            array_merge(
                ['rental_id' => $updateRentalRequest->getRentalId()],
                $updateRentalRequest->getAttributes()
            )
        );

        $rental = $this->rentalRepository->update(
            $updateRentalRequest->getRentalId(),
            $this->rentalMapper->map($updateRentalRequest->getAttributes())
        );

        return $this->transformer->item($rental, RentalTransformerInterface::class);
    }
}
