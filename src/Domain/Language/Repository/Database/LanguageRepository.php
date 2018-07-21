<?php declare(strict_types=1);

namespace Sakila\Domain\Language\Repository\Database;

use Sakila\Domain\Language\Repository\LanguageRepository as LanguageRepositoryInterface;
use Sakila\Repository\Database\AbstractDatabaseRepository;

class LanguageRepository extends AbstractDatabaseRepository implements LanguageRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'language_id';
}
