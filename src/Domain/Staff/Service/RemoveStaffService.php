<?php declare(strict_types=1);

namespace Sakila\Domain\Staff\Service;

use Sakila\Domain\Staff\Repository\StaffRepository;
use Sakila\Domain\Staff\Service\Request\RemoveStaffRequest;

class RemoveStaffService
{
    /**
     * @var \Sakila\Domain\Staff\Repository\StaffRepository
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Staff\Repository\StaffRepository $repository
     */
    public function __construct(StaffRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(RemoveStaffRequest $removeStaffRequest)
    {
        return $this->repository->remove($removeStaffRequest->getStaffId());
    }
}
