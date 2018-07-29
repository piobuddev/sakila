<?php declare(strict_types=1);

namespace Sakila\Domain\Staff\Commands\Handlers;

use Sakila\Domain\Staff\Commands\AddStaffCommand;
use Sakila\Domain\Staff\Commands\UpdateStaffCommand;
use Sakila\Domain\Staff\Entity\Mapper\StaffMapper;
use Sakila\Domain\Staff\Repository\StaffRepository;
use Sakila\Domain\Staff\Validator\StaffValidator;
use Sakila\Entity\EntityInterface;

class StaffHandler
{
    /**
     * @var \Sakila\Domain\Staff\Entity\Mapper\StaffMapper
     */
    private $staffMapper;

    /**
     * @var \Sakila\Domain\Staff\Repository\StaffRepository
     */
    private $staffRepository;

    /**
     * @var \Sakila\Domain\Staff\Validator\StaffValidator
     */
    private $validator;

    /**
     * @param \Sakila\Domain\Staff\Entity\Mapper\StaffMapper  $mapper
     * @param \Sakila\Domain\Staff\Repository\StaffRepository $repository
     * @param \Sakila\Domain\Staff\Validator\StaffValidator   $validator
     */
    public function __construct(StaffMapper $mapper, StaffRepository $repository, StaffValidator $validator)
    {
        $this->staffMapper     = $mapper;
        $this->staffRepository = $repository;
        $this->validator       = $validator;
    }

    /**
     * @param \Sakila\Domain\Staff\Commands\AddStaffCommand $command
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function handleAddStaff(AddStaffCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->staffRepository->add($this->staffMapper->map($command->getAttributes()));

        $staffId = $this->staffRepository->lastInsertedId();
        $staff   = $this->staffRepository->get($staffId);

        return $staff;
    }


    /**
     * @param \Sakila\Domain\Staff\Commands\UpdateStaffCommand $command
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function handleUpdateStaff(UpdateStaffCommand $command): EntityInterface
    {
        $attributes = array_merge(['staff_id' => $command->getStaffId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->staffRepository->update(
            $command->getStaffId(),
            $this->staffMapper->map($command->getAttributes())
        );
    }
}
