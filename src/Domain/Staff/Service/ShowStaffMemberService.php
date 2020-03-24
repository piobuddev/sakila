<?php declare(strict_types=1);

namespace Sakila\Domain\Staff\Service;

use Sakila\Domain\Staff\Entity\Transformer\StaffTransformerInterface;
use Sakila\Domain\Staff\Repository\StaffRepositoryInterface;
use Sakila\Domain\Staff\Service\Request\ShowStaffMemberRequest;
use Sakila\Transformer\TransformerInterface;

class ShowStaffMemberService
{
    /**
     * @var \Sakila\Domain\Staff\Repository\StaffRepositoryInterface
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Staff\Repository\StaffRepositoryInterface $repository
     * @param \Sakila\Transformer\TransformerInterface                 $transformer
     */
    public function __construct(StaffRepositoryInterface $repository, TransformerInterface $transformer)
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
