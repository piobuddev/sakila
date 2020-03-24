<?php declare(strict_types=1);

namespace Sakila\Domain\Rental\Service;

use Sakila\Domain\Rental\Entity\Mapper\RentalMapper;
use Sakila\Domain\Rental\Entity\Transformer\RentalTransformerInterface;
use Sakila\Domain\Rental\Repository\RentalRepositoryInterface;
use Sakila\Domain\Rental\Service\Request\AddRentalRequest;
use Sakila\Domain\Rental\Validator\RentalValidatorInterface;
use Sakila\Transformer\TransformerInterface;

class AddRentalService
{
    /**
     * @var \Sakila\Domain\Rental\Validator\RentalValidatorInterface
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Rental\Repository\RentalRepositoryInterface
     */
    private $rentalRepository;

    /**
     * @var \Sakila\Domain\Rental\Entity\Mapper\RentalMapper
     */
    private $rentalMapper;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Rental\Validator\RentalValidatorInterface   $validator
     * @param \Sakila\Domain\Rental\Repository\RentalRepositoryInterface $repository
     * @param \Sakila\Domain\Rental\Entity\Mapper\RentalMapper           $rentalMapper
     * @param \Sakila\Transformer\TransformerInterface                   $transformer
     */
    public function __construct(
        RentalValidatorInterface $validator,
        RentalRepositoryInterface $repository,
        RentalMapper $rentalMapper,
        TransformerInterface $transformer
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
