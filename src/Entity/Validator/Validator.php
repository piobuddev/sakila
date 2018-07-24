<?php declare(strict_types=1);

namespace Sakila\Entity\Validator;

interface Validator
{
    /**
     * @param array $attributes
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException;
     */
    public function validate(array $attributes);
}
