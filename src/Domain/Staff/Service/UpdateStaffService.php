<?php declare(strict_types=1);

namespace Sakila\Domain\Staff\Service;

use Sakila\Domain\Staff\Entity\Mapper\StaffMapper;
use Sakila\Domain\Staff\Entity\Transformer\StaffTransformerInterface;
use Sakila\Domain\Staff\Repository\StaffRepository;
use Sakila\Domain\Staff\Service\Request\UpdateStaffRequest;
use Sakila\Domain\Staff\Validator\StaffValidator;
use Sakila\Transformer\Transformer;

class UpdateStaffService
{
    /**
     * @var \Sakila\Domain\Staff\Validator\StaffValidator
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Staff\Repository\StaffRepository
     */
    private $staffRepository;

    /**
     * @var \Sakila\Domain\Staff\Entity\Mapper\StaffMapper
     */
    private $staffMapper;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Staff\Validator\StaffValidator   $validator
     * @param \Sakila\Domain\Staff\Repository\StaffRepository $repository
     * @param \Sakila\Domain\Staff\Entity\Mapper\StaffMapper  $staffMapper
     * @param \Sakila\Transformer\Transformer                 $transformer
     */
    public function __construct(
        StaffValidator $validator,
        StaffRepository $repository,
        StaffMapper $staffMapper,
        Transformer $transformer
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
