<?php declare(strict_types=1);

namespace Sakila\Domain\Language\Entity;

use Sakila\Entity\AbstractEntity;

class LanguageEntity extends AbstractEntity
{
    /**
     * @var int
     */
    public $languageId;

    /**
     * @var string
     */
    public $name;
}
