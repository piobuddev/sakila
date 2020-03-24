<?php declare(strict_types=1);

namespace Sakila\Domain\Payment\Service\Request;

use Sakila\Command\CommandInterface;

class RemovePaymentRequest implements CommandInterface
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
