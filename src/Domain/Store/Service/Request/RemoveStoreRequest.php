<?php declare(strict_types=1);

namespace Sakila\Domain\Store\Service\Request;

use Sakila\Command\CommandInterface;

class RemoveStoreRequest implements CommandInterface
{
    /**
     * @var int
     */
    private $storeId;

    /**
     * @param int $storeId
     */
    public function __construct(int $storeId)
    {
        $this->setStoreId($storeId);
    }

    /**
     * @return int
     */
    public function getStoreId(): int
    {
        return $this->storeId;
    }

    /**
     * @param int $storeId
     */
    private function setStoreId(int $storeId): void
    {
        $this->storeId = $storeId;
    }
}
