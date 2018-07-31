<?php declare(strict_types=1);

namespace Sakila\Domain\Payment\Entity\Mapper;

use Sakila\Entity\Mapper\AbstractMapper;

class PaymentMapper extends AbstractMapper
{
    /**
     * @return array
     */
    protected function getMapping(): array
    {
        return [
            'paymentId'   => 'payment_id',
            'customerId'  => 'customer_id',
            'staffId'     => 'staff_id',
            'rentalId'    => 'rental_id',
            'amount'      => 'amount',
            'paymentDate' => 'payment_date',
        ];
    }
}
