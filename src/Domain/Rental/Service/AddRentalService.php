<?php declare(strict_types=1);

namespace Sakila\Domain\Rental\Service;

use Sakila\Domain\Rental\Entity\Mapper\RentalMapper;
use Sakila\Domain\Rental\Entity\Transformer\RentalTransformerInterface;
use Sakila\Domain\Rental\Repository\RentalRepository;
use Sakila\Domain\Rental\Service\Request\AddRentalRequest;
use Sakila\Domain\Rental\Validator\RentalValidator;
use Sakila\Transformer\Transformer;

class AddRentalService
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
     * @param \Sakila\Domain\Rental\Service\Request\AddRentalRequest $addRentalRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(AddRentalRequest $addRentalRequest)
    {
        $this->validator->validate($addRentalRequest->getAttributes());
        $this->rentalRepository->add($this->rentalMapper->map($addRentalRequest->getAttributes()));

        $rentalId = $this->rentalRepository->lastInsertedId();
        $rental   = $this->rentalRepository->get($rentalId);

        return $this->transformer->item($rental, RentalTransformerInterface::class);
    }
}
