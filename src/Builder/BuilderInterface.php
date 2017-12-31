<?php declare(strict_types=1);

namespace Sakila\Builder;

interface BuilderInterface
{
    /**
     * @param mixed $resource
     * @param mixed $data
     *
     * @return mixed
     */
    public function build($resource, $data);
}
