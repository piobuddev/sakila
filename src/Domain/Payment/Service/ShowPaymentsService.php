<?php declare(strict_types=1);

namespace Sakila\Domain\Payment\Service;

use Sakila\Domain\Payment\Entity\Transformer\PaymentTransformerInterface;
use Sakila\Domain\Payment\Repository\PaymentRepositoryInterface;
use Sakila\Domain\Payment\Service\Request\ShowPaymentsRequest;
use Sakila\Transformer\TransformerInterface;

class ShowPaymentsService
{
    /**
     * @var \Sakila\Domain\Payment\Repository\PaymentRepositoryInterface
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Payment\Repository\PaymentRepositoryInterface $repository
     * @param \Sakila\Transformer\TransformerInterface                     $transformer
     */
    public function __construct(
        PaymentRepositoryInterface $repository,
        TransformerInterface $transformer
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
