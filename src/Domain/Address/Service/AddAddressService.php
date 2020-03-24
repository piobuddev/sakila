<?php declare(strict_types=1);

namespace Sakila\Domain\Address\Service;

use Sakila\Domain\Address\Entity\Mapper\AddressMapper;
use Sakila\Domain\Address\Entity\Transformer\AddressTransformerInterface;
use Sakila\Domain\Address\Repository\AddressRepositoryInterface;
use Sakila\Domain\Address\Service\Request\AddAddressRequest;
use Sakila\Domain\Address\Validator\AddressValidatorInterface;
use Sakila\Transformer\TransformerInterface;

class AddAddressService
{
    /**
     * @var \Sakila\Domain\Address\Validator\AddressValidatorInterface
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Address\Repository\AddressRepositoryInterface
     */
    private $addressRepository;

    /**
     * @var \Sakila\Domain\Address\Entity\Mapper\AddressMapper
     */
    private $addressMapper;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Address\Validator\AddressValidatorInterface   $validator
     * @param \Sakila\Domain\Address\Repository\AddressRepositoryInterface $repository
     * @param \Sakila\Domain\Address\Entity\Mapper\AddressMapper           $addressMapper
     * @param \Sakila\Transformer\TransformerInterface                     $transformer
     */
    public function __construct(
        AddressValidatorInterface $validator,
        AddressRepositoryInterface $repository,
        AddressMapper $addressMapper,
        TransformerInterface $transformer
    ) {
        $this->validator         = $validator;
        $this->addressRepository = $repository;
        $this->addressMapper     = $addressMapper;
        $this->transformer       = $transformer;
    }

    /**
     * @param \Sakila\Domain\Address\Service\Request\AddAddressRequest $addAddressRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(AddAddressRequest $addAddressRequest)
    {
        $this->validator->validate($addAddressRequest->getAttributes());
        $this->addressRepository->add($this->addressMapper->map($addAddressRequest->getAttributes()));

        $addressId = $this->addressRepository->lastInsertedId();
        $address   = $this->addressRepository->get($addressId);

        return $this->transformer->item($address, AddressTransformerInterface::class);
    }
}
