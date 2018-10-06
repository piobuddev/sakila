<?php declare(strict_types=1);

namespace Sakila\Domain\Payment\Service;

use Sakila\Domain\Payment\Entity\Transformer\PaymentTransformerInterface;
use Sakila\Domain\Payment\Repository\PaymentRepository;
use Sakila\Domain\Payment\Service\Request\ShowPaymentsRequest;
use Sakila\Transformer\Transformer;

class ShowPaymentsService
{
    /**
     * @var \Sakila\Domain\Payment\Repository\PaymentRepository
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Payment\Repository\PaymentRepository $repository
     * @param \Sakila\Transformer\Transformer                     $transformer
     */
    public function __construct(
        PaymentRepository $repository,
        Transformer $transformer
    ) {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Payment\Service\Request\ShowPaymentsRequest $showPaymentsRequest
     *
     * @return mixed
     */
    public function execute(ShowPaymentsRequest $showPaymentsRequest)
    {
        $page     = $showPaymentsRequest->getPage();
        $pageSize = $showPaymentsRequest->getPageSize();
        $payments = $this->repository->all($page, $pageSize);
        $total    = $this->repository->count();

        return $this->transformer->collection(
            $payments,
            PaymentTransformerInterface::class,
            $page,
            $pageSize,
            $total
        );
    }
}
