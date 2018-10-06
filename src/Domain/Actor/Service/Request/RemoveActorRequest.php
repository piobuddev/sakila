<?php declare(strict_types=1);

namespace Sakila\Domain\Actor\Service\Request;

use Sakila\Command\Command;

class RemoveActorRequest implements Command
{
    /**
     * @var int
     */
    private $actorId;

    /**
     * @param int $actorId
     */
    public function __construct(int $actorId)
    {
        $this->setActorId($actorId);
    }

    /**
     * @return int
     */
    public function getActorId(): int
    {
        return $this->actorId;
    }

    /**
     * @param int $actorId
     */
    private function setActorId(int $actorId): void
    {
        $this->actorId = $actorId;
    }
}