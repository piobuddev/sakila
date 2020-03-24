<?php declare(strict_types=1);

namespace Sakila\Domain\Payment\Repository\Database;

use Sakila\Domain\Payment\Repository\PaymentRepositoryInterface;
use Sakila\Repository\Database\AbstractDatabaseRepository;

class PaymentRepository extends AbstractDatabaseRepository implements PaymentRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'payment_id';
}
