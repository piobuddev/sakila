<?php declare(strict_types=1);

namespace Sakila\Domain\Payment\Commands;

use Sakila\Command\AbstractCommand;

class UpdatePaymentCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $paymentId;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param int   $paymentId
     * @param array $attributes
     */
    public function __construct(int $paymentId, array $attributes)
    {
        $this->paymentId  = $paymentId;
        $this->attributes = $attributes;
    }

    /**
     * @return int
     */
    public function getPaymentId(): int
    {
        return $this->paymentId;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
