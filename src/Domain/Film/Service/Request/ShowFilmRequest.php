<?php declare(strict_types=1);

namespace Sakila\Domain\Film\Service\Request;

use Sakila\Command\Command;

class ShowFilmRequest implements Command
{
    /**
     * @var int
     */
    private $filmId;

    /**
     * @param int $filmId
     */
    public function __construct(int $filmId)
    {
        $this->setFilmId($filmId);
    }

    /**
     * @return int
     */
    public function getFilmId(): int
    {
        return $this->filmId;
    }

    /**
     * @param int $filmId
     */
    private function setFilmId(int $filmId): void
    {
        $this->filmId = $filmId;
    }
}
