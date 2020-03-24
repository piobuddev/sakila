<?php declare(strict_types=1);

namespace Sakila\Domain\Language\Service\Request;

use Sakila\Command\CommandInterface;

class RemoveLanguageRequest implements CommandInterface
{
    /**
     * @var int
     */
    private $languageId;

    /**
     * @param int $languageId
     */
    public function __construct(int $languageId)
    {
        $this->setLanguageId($languageId);
    }

    /**
     * @return int
     */
    public function getLanguageId(): int
    {
        return $this->languageId;
    }

    /**
     * @param int $languageId
     */
    private function setLanguageId(int $languageId): void
    {
        $this->languageId = $languageId;
    }
}
