<?php declare(strict_types=1);

namespace Sakila\Domain\Payment\Service;

use Sakila\Domain\Payment\Repository\PaymentRepository;
use Sakila\Domain\Payment\Service\Request\RemovePaymentRequest;

class RemovePaymentService
{
    /**
     * @var \Sakila\Domain\Payment\Repository\PaymentRepository
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Payment\Repository\PaymentRepository $repository
     */
    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(RemovePaymentRequest $removePaymentRequest)
    {
        return $this->repository->remove($removePaymentRequest->getPaymentId());
    }
}
