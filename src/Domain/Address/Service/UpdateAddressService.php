<?php declare(strict_types=1);

namespace Sakila\Domain\Address\Service;

use Sakila\Domain\Address\Entity\Mapper\AddressMapper;
use Sakila\Domain\Address\Entity\Transformer\AddressTransformerInterface;
use Sakila\Domain\Address\Repository\AddressRepository;
use Sakila\Domain\Address\Service\Request\UpdateAddressRequest;
use Sakila\Domain\Address\Validator\AddressValidator;
use Sakila\Transformer\Transformer;

class UpdateAddressService
{
    /**
     * @var \Sakila\Domain\Address\Validator\AddressValidator
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Address\Repository\AddressRepository
     */
    private $addressRepository;

    /**
     * @var \Sakila\Domain\Address\Entity\Mapper\AddressMapper
     */
    private $addressMapper;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Address\Validator\AddressValidator   $validator
     * @param \Sakila\Domain\Address\Repository\AddressRepository $repository
     * @param \Sakila\Domain\Address\Entity\Mapper\AddressMapper  $addressMapper
     * @param \Sakila\Transformer\Transformer                     $transformer
     */
    public function __construct(
        AddressValidator $validator,
        AddressRepository $repository,
        AddressMapper $addressMapper,
        Transformer $transformer
    ) {
        $this->validator         = $validator;
        $this->addressRepository = $repository;
        $this->addressMapper     = $addressMapper;
        $this->transformer       = $transformer;
    }

    /**
     * @param \Sakila\Domain\Address\Service\Request\UpdateAddressRequest $updateAddressRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(UpdateAddressRequest $updateAddressRequest)
    {
        $this->validator->validate(
            array_merge(
                ['address_id' => $updateAddressRequest->getAddressId()],
                $updateAddressRequest->getAttributes()
            )
        );

        $address = $this->addressRepository->update(
            $updateAddressRequest->getAddressId(),
            $this->addressMapper->map($updateAddressRequest->getAttributes())
        );

        return $this->transformer->item($address, AddressTransformerInterface::class);
    }
}
