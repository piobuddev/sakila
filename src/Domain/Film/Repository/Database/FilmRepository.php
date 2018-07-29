<?php declare(strict_types=1);

namespace Sakila\Domain\Film\Repository\Database;

use Sakila\Domain\Film\Repository\FilmRepository as FilmRepositoryInterface;
use Sakila\Repository\Database\AbstractDatabaseRepository;

class FilmRepository extends AbstractDatabaseRepository implements FilmRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'film_id';
}
