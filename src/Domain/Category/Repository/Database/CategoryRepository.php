<?php declare(strict_types=1);

namespace Sakila\Domain\Category\Repository\Database;

use Sakila\Domain\Category\Repository\CategoryRepository as CategoryRepositoryInterface;
use Sakila\Repository\Database\AbstractDatabaseRepository;

class CategoryRepository extends AbstractDatabaseRepository implements CategoryRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'category_id';
}
