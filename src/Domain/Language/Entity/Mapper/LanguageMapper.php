<?php declare(strict_types=1);

namespace Sakila\Domain\Language\Entity\Mapper;

use Sakila\Entity\Mapper\AbstractMapper;

class LanguageMapper extends AbstractMapper
{
    /**
     * @return array
     */
    protected function getMapping(): array
    {
        return [
            'id' => 'language_id',
        ];
    }
}
