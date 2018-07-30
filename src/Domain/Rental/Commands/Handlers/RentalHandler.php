<?php declare(strict_types=1);

namespace Sakila\Domain\Rental\Commands\Handlers;

use Sakila\Domain\Rental\Commands\AddRentalCommand;
use Sakila\Domain\Rental\Commands\UpdateRentalCommand;
use Sakila\Domain\Rental\Entity\Mapper\RentalMapper;
use Sakila\Domain\Rental\Repository\RentalRepository;
use Sakila\Domain\Rental\Validator\RentalValidator;
use Sakila\Entity\EntityInterface;

class RentalHandler
{
    /**
     * @var \Sakila\Domain\Rental\Entity\Mapper\RentalMapper
     */
    private $rentalMapper;

    /**
     * @var \Sakila\Domain\Rental\Repository\RentalRepository
     */
    private $rentalRepository;

    /**
     * @var \Sakila\Domain\Rental\Validator\RentalValidator
     */
    private $validator;

    /**
     * @param \Sakila\Domain\Rental\Entity\Mapper\RentalMapper  $mapper
     * @param \Sakila\Domain\Rental\Repository\RentalRepository $repository
     * @param \Sakila\Domain\Rental\Validator\RentalValidator   $validator
     */
    public function __construct(RentalMapper $mapper, RentalRepository $repository, RentalValidator $validator)
    {
        $this->rentalMapper     = $mapper;
        $this->rentalRepository = $repository;
        $this->validator        = $validator;
    }

    /**
     * @param \Sakila\Domain\Rental\Commands\AddRentalCommand $command
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function handleAddRental(AddRentalCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->rentalRepository->add($this->rentalMapper->map($command->getAttributes()));

        $rentalId = $this->rentalRepository->lastInsertedId();
        $rental   = $this->rentalRepository->get($rentalId);

        return $rental;
    }


    /**
     * @param \Sakila\Domain\Rental\Commands\UpdateRentalCommand $command
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function handleUpdateRental(UpdateRentalCommand $command): EntityInterface
    {
        $attributes = array_merge(['rental_id' => $command->getRentalId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->rentalRepository->update(
            $command->getRentalId(),
            $this->rentalMapper->map($command->getAttributes())
        );
    }
}
