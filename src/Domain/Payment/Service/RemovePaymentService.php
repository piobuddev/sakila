<?php declare(strict_types=1);

namespace Sakila\Domain\Payment\Service;

use Sakila\Domain\Payment\Repository\PaymentRepositoryInterface;
use Sakila\Domain\Payment\Service\Request\RemovePaymentRequest;

class RemovePaymentService
{
    /**
     * @var \Sakila\Domain\Payment\Repository\PaymentRepositoryInterface
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Payment\Repository\PaymentRepositoryInterface $repository
     */
    public function __construct(PaymentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Sakila\Domain\Payment\Service\Request\RemovePaymentRequest $removePaymentRequest
     *
     * @return bool
     */
    public function execute(RemovePaymentRequest $removePaymentRequest): bool
    {
        return $this->repository->remove($removePaymentRequest->getPaymentId());
    }
}
