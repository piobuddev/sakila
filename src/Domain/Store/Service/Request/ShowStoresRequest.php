<?php declare(strict_types=1);

namespace Sakila\Domain\Store\Service\Request;

use Sakila\Command\Command;

class ShowStoresRequest implements Command
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