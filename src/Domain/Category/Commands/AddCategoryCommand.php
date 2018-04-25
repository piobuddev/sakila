<?php declare(strict_types=1);

namespace Sakila\Domain\Category\Commands;

use phpDocumentor\Reflection\Types\Void_;
use Sakila\Command\AbstractCommand;
use Sakila\Domain\Category\Entity\CategoryEntity;

class AddCategoryCommand extends AbstractCommand
{
    /**
     * @var array
     */
    private $attributes;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $this->filterAttributes($attributes, CategoryEntity::class);
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }
}
