<?php declare(strict_types=1);

namespace Sakila\Domain\Actor\Entity\Mapper;

use Sakila\Entity\Mapper\AbstractMapper;

class ActorMapper extends AbstractMapper
{
    /**
     * @return array
     */
    protected function getMapping(): array
    {
        return [
            'id'        => 'actor_id',
            'firstName' => 'first_name',
            'lastName'  => 'last_name',
        ];
    }
}
