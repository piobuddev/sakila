<?php declare(strict_types=1);

namespace Sakila\Domain\Payment\Service;

use Sakila\Domain\Payment\Entity\Mapper\PaymentMapper;
use Sakila\Domain\Payment\Entity\Transformer\PaymentTransformerInterface;
use Sakila\Domain\Payment\Repository\PaymentRepositoryInterface;
use Sakila\Domain\Payment\Service\Request\AddPaymentRequest;
use Sakila\Domain\Payment\Validator\PaymentValidatorInterface;
use Sakila\Transformer\TransformerInterface;

class AddPaymentService
{
    /**
     * @var \Sakila\Domain\Payment\Validator\PaymentValidatorInterface
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Payment\Repository\PaymentRepositoryInterface
     */
    private $paymentRepository;

    /**
     * @var \Sakila\Domain\Payment\Entity\Mapper\PaymentMapper
     */
    private $paymentMapper;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Payment\Validator\PaymentValidatorInterface   $validator
     * @param \Sakila\Domain\Payment\Repository\PaymentRepositoryInterface $repository
     * @param \Sakila\Domain\Payment\Entity\Mapper\PaymentMapper           $paymentMapper
     * @param \Sakila\Transformer\TransformerInterface                     $transformer
     */
    public function __construct(
        PaymentValidatorInterface $validator,
        PaymentRepositoryInterface $repository,
        PaymentMapper $paymentMapper,
        TransformerInterface $transformer
    ) {
        $this->validator         = $validator;
        $this->paymentRepository = $repository;
        $this->paymentMapper     = $paymentMapper;
        $this->transformer       = $transformer;
    }

    /**
     * @param \Sakila\Domain\Payment\Service\Request\AddPaymentRequest $addPaymentRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(AddPaymentRequest $addPaymentRequest)
    {
        $this->validator->validate($addPaymentRequest->getAttributes());
        $this->paymentRepository->add($this->paymentMapper->map($addPaymentRequest->getAttributes()));

        $paymentId = $this->paymentRepository->lastInsertedId();
        $payment   = $this->paymentRepository->get($paymentId);

        return $this->transformer->item($payment, PaymentTransformerInterface::class);
    }
}
