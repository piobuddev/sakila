<?php declare(strict_types=1);

namespace Sakila\Domain\Language\Service\Request;

use Sakila\Command\AbstractCommand;

class UpdateLanguageRequest extends AbstractCommand
{
    /**
     * @var int
     */
    private $languageId;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param int   $languageId
     * @param array $attributes
     */
    public function __construct(int $languageId, array $attributes)
    {
        $this->languageId = $languageId;
        $this->attributes = $attributes;
    }

    /**
     * @return int
     */
    public function getLanguageId(): int
    {
        return $this->languageId;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
