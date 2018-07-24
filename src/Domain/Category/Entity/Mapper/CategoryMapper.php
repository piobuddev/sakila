<?php declare(strict_types=1);

namespace Sakila\Domain\Category\Entity\Mapper;

use Sakila\Entity\Mapper\AbstractMapper;

class CategoryMapper extends AbstractMapper
{
    /**
     * @return array
     */
    protected function getMapping(): array
    {
        return [
            'id'   => 'category_id',
            'name' => 'name',
        ];
    }
}
