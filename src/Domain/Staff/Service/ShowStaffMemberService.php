<?php declare(strict_types=1);

namespace Sakila\Domain\Staff\Service;

use Sakila\Domain\Staff\Entity\Transformer\StaffTransformerInterface;
use Sakila\Domain\Staff\Repository\StaffRepository;
use Sakila\Domain\Staff\Service\Request\ShowStaffMemberRequest;
use Sakila\Transformer\Transformer;

class ShowStaffMemberService
{
    /**
     * @var \Sakila\Domain\Staff\Repository\StaffRepository
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Staff\Repository\StaffRepository $repository
     * @param \Sakila\Transformer\Transformer                 $transformer
     */
    public function __construct(StaffRepository $repository, Transformer $transformer)
    {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Staff\Service\Request\ShowStaffMemberRequest $showStaffRequest
     *
     * @return mixed
     */
    public function execute(ShowStaffMemberRequest $showStaffRequest)
    {
        $staff = $this->repository->get($showStaffRequest->getStaffId());

        return $this->transformer->item($staff, StaffTransformerInterface::class);
    }
}
