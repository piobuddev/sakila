<?php declare(strict_types=1);

namespace Sakila\Domain\Store\Service\Request;

use Sakila\Command\CommandInterface;

class ShowStoresRequest implements CommandInterface
{
    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $pageSize;

    /**
     * @param int $page
     * @param int $pageSize
     */
    public function __construct(int $page, int $pageSize)
    {
        $this->page     = $page;
        $this->pageSize = $pageSize;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }
}
