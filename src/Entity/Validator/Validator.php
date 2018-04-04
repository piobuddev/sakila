<?php declare(strict_types=1);

namespace Sakila\Entity\Validator;

interface Validator
{
    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function validate(array $attributes);
}
