<?php declare(strict_types=1);

namespace Sakila\Domain\Payment\Service\Request;

use Sakila\Command\Command;

class RemovePaymentRequest implements Command
{
    /**
     * @var int
     */
    private $paymentId;

    /**
     * @param int $paymentId
     */
    public function __construct(int $paymentId)
    {
        $this->setPaymentId($paymentId);
    }

    /**
     * @return int
     */
    public function getPaymentId(): int
    {
        return $this->paymentId;
    }

    /**
     * @param int $paymentId
     */
    private function setPaymentId(int $paymentId): void
    {
        $this->paymentId = $paymentId;
    }
}
