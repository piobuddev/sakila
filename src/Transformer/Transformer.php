<?php declare(strict_types=1);

namespace Sakila\Transformer;

interface Transformer
{
    /**
     * @param $entity
     *
     * @return array
     */
    public function transform($entity): array;
}
