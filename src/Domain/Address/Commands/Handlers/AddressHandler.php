<?php declare(strict_types=1);

namespace Sakila\Domain\Address\Commands\Handlers;

use Sakila\Domain\Address\Commands\AddAddressCommand;
use Sakila\Domain\Address\Commands\UpdateAddressCommand;
use Sakila\Domain\Address\Entity\Mapper\AddressMapper;
use Sakila\Domain\Address\Repository\AddressRepository;
use Sakila\Domain\Address\Validator\AddressValidator;
use Sakila\Entity\EntityInterface;

class AddressHandler
{
    /**
     * @var \Sakila\Domain\Address\Entity\Mapper\AddressMapper
     */
    private $addressMapper;

    /**
     * @var \Sakila\Domain\Address\Repository\AddressRepository
     */
    private $addressRepository;

    /**
     * @var \Sakila\Domain\Address\Validator\AddressValidator
     */
    private $validator;

    /**
     * @param \Sakila\Domain\Address\Entity\Mapper\AddressMapper  $mapper
     * @param \Sakila\Domain\Address\Repository\AddressRepository $repository
     * @param \Sakila\Domain\Address\Validator\AddressValidator   $validator
     */
    public function __construct(AddressMapper $mapper, AddressRepository $repository, AddressValidator $validator)
    {
        $this->addressMapper     = $mapper;
        $this->addressRepository = $repository;
        $this->validator         = $validator;
    }

    /**
     * @param \Sakila\Domain\Address\Commands\AddAddressCommand $command
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function handleAddAddress(AddAddressCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->addressRepository->add($this->addressMapper->map($command->getAttributes()));

        $addressId = $this->addressRepository->lastInsertedId();
        $address   = $this->addressRepository->get($addressId);

        return $address;
    }

    /**
     * @param \Sakila\Domain\Address\Commands\UpdateAddressCommand $command
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function handleUpdateAddress(UpdateAddressCommand $command): EntityInterface
    {
        $attributes = array_merge(['address_id' => $command->getAddressId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->addressRepository->update(
            $command->getAddressId(),
            $this->addressMapper->map($command->getAttributes())
        );
    }
}
