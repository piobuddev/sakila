<?php declare(strict_types=1);

namespace Sakila\Domain\Staff\Service;

use Sakila\Domain\Staff\Entity\Mapper\StaffMapper;
use Sakila\Domain\Staff\Entity\Transformer\StaffTransformerInterface;
use Sakila\Domain\Staff\Repository\StaffRepository;
use Sakila\Domain\Staff\Service\Request\AddStaffRequest;
use Sakila\Domain\Staff\Validator\StaffValidator;
use Sakila\Transformer\Transformer;

class AddStaffService
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
     * @param \Sakila\Domain\Staff\Service\Request\AddStaffRequest $addStaffRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(AddStaffRequest $addStaffRequest)
    {
        $this->validator->validate($addStaffRequest->getAttributes());
        $this->staffRepository->add($this->staffMapper->map($addStaffRequest->getAttributes()));

        $staffId = $this->staffRepository->lastInsertedId();
        $staff   = $this->staffRepository->get($staffId);

        return $this->transformer->item($staff, StaffTransformerInterface::class);
    }
}
