<?php declare(strict_types=1);

namespace Sakila\Domain\Staff\Service\Request;

use Sakila\Command\AbstractCommand;

class UpdateStaffRequest extends AbstractCommand
{
    /**
     * @var int
     */
    private $staffId;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param int   $staffId
     * @param array $attributes
     */
    public function __construct(int $staffId, array $attributes)
    {
        $this->staffId    = $staffId;
        $this->attributes = $attributes;
    }

    /**
     * @return int
     */
    public function getStaffId(): int
    {
        return $this->staffId;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
