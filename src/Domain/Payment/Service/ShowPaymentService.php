<?php declare(strict_types=1);

namespace Sakila\Domain\Payment\Service;

use Sakila\Domain\Payment\Entity\Transformer\PaymentTransformerInterface;
use Sakila\Domain\Payment\Repository\PaymentRepository;
use Sakila\Domain\Payment\Service\Request\ShowPaymentRequest;
use Sakila\Transformer\Transformer;

class ShowPaymentService
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
    public function __construct(PaymentRepository $repository, Transformer $transformer)
    {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Payment\Service\Request\ShowPaymentRequest $showPaymentRequest
     *
     * @return mixed
     */
    public function execute(ShowPaymentRequest $showPaymentRequest)
    {
        $payment = $this->repository->get($showPaymentRequest->getPaymentId());

        return $this->transformer->item($payment, PaymentTransformerInterface::class);
    }
}
