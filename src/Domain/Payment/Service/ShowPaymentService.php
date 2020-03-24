<?php declare(strict_types=1);

namespace Sakila\Domain\Payment\Service;

use Sakila\Domain\Payment\Entity\Transformer\PaymentTransformerInterface;
use Sakila\Domain\Payment\Repository\PaymentRepositoryInterface;
use Sakila\Domain\Payment\Service\Request\ShowPaymentRequest;
use Sakila\Transformer\TransformerInterface;

class ShowPaymentService
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
    public function __construct(PaymentRepositoryInterface $repository, TransformerInterface $transformer)
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
