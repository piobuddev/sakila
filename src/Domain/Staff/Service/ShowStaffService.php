<?php declare(strict_types=1);

namespace Sakila\Domain\Staff\Service;

use Sakila\Domain\Staff\Entity\Transformer\StaffTransformerInterface;
use Sakila\Domain\Staff\Repository\StaffRepositoryInterface;
use Sakila\Domain\Staff\Service\Request\ShowStaffRequest;
use Sakila\Transformer\TransformerInterface;

class ShowStaffService
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
    public function __construct(
        StaffRepositoryInterface $repository,
        TransformerInterface $transformer
    ) {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Staff\Service\Request\ShowStaffRequest $showStaffRequest
     *
     * @return mixed
     */
    public function execute(ShowStaffRequest $showStaffRequest)
    {
        $page     = $showStaffRequest->getPage();
        $pageSize = $showStaffRequest->getPageSize();
        $staff   = $this->repository->all($page, $pageSize);
        $total    = $this->repository->count();

        return $this->transformer->collection(
            $staff,
            StaffTransformerInterface::class,
            $page,
            $pageSize,
            $total
        );
    }
}
