<?php declare(strict_types=1);

namespace Sakila\Domain\Staff\Service\Request;

use Sakila\Command\Command;

class ShowStaffMemberRequest implements Command
{
    /**
     * @var int
     */
    private $staffId;

    /**
     * @param int $staffId
     */
    public function __construct(int $staffId)
    {
        $this->setStaffId($staffId);
    }

    /**
     * @return int
     */
    public function getStaffId(): int
    {
        return $this->staffId;
    }

    /**
     * @param int $staffId
     */
    private function setStaffId(int $staffId): void
    {
        $this->staffId = $staffId;
    }
}
