<?php declare(strict_types=1);

namespace Sakila\Entity;

use JsonSerializable;

interface EntityInterface extends JsonSerializable
{
    /**
     * @param array $data
     *
     * @return \Sakila\Entity\EntityInterface
     */
    public function fill(array $data);
}
