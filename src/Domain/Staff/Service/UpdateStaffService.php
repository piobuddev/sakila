<?php declare(strict_types=1);

namespace Sakila\Domain\Staff\Service;

use Sakila\Domain\Staff\Entity\Mapper\StaffMapper;
use Sakila\Domain\Staff\Entity\Transformer\StaffTransformerInterface;
use Sakila\Domain\Staff\Repository\StaffRepositoryInterface;
use Sakila\Domain\Staff\Service\Request\UpdateStaffRequest;
use Sakila\Domain\Staff\Validator\StaffValidatorInterface;
use Sakila\Transformer\TransformerInterface;

class UpdateStaffService
{
    /**
     * @var \Sakila\Domain\Staff\Validator\StaffValidatorInterface
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Staff\Repository\StaffRepositoryInterface
     */
    private $staffRepository;

    /**
     * @var \Sakila\Domain\Staff\Entity\Mapper\StaffMapper
     */
    private $staffMapper;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Staff\Validator\StaffValidatorInterface   $validator
     * @param \Sakila\Domain\Staff\Repository\StaffRepositoryInterface $repository
     * @param \Sakila\Domain\Staff\Entity\Mapper\StaffMapper           $staffMapper
     * @param \Sakila\Transformer\TransformerInterface                 $transformer
     */
    public function __construct(
        StaffValidatorInterface $validator,
        StaffRepositoryInterface $repository,
        StaffMapper $staffMapper,
        TransformerInterface $transformer
    ) {
        $this->validator       = $validator;
        $this->staffRepository = $repository;
        $this->staffMapper     = $staffMapper;
        $this->transformer     = $transformer;
    }

    /**
     * @param \Sakila\Domain\Staff\Service\Request\UpdateStaffRequest $updateStaffRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(UpdateStaffRequest $updateStaffRequest)
    {
        $this->validator->validate(
            array_merge(
                ['staff_id' => $updateStaffRequest->getStaffId()],
                $updateStaffRequest->getAttributes()
            )
        );

        $staff = $this->staffRepository->update(
            $updateStaffRequest->getStaffId(),
            $this->staffMapper->map($updateStaffRequest->getAttributes())
        );

        return $this->transformer->item($staff, StaffTransformerInterface::class);
    }
}
