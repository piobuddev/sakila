<?php declare(strict_types=1);

namespace Sakila\Domain\Staff\Service;

use Sakila\Domain\Staff\Repository\StaffRepositoryInterface;
use Sakila\Domain\Staff\Service\Request\RemoveStaffRequest;

class RemoveStaffService
{
    /**
     * @var \Sakila\Domain\Staff\Repository\StaffRepositoryInterface
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Staff\Repository\StaffRepositoryInterface $repository
     */
    public function __construct(StaffRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Sakila\Domain\Staff\Service\Request\RemoveStaffRequest $removeStaffRequest
     *
     * @return bool
     */
    public function execute(RemoveStaffRequest $removeStaffRequest): bool
    {
        return $this->repository->remove($removeStaffRequest->getStaffId());
    }
}
