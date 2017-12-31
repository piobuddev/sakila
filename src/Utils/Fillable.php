<?php declare(strict_types=1);

namespace Sakila\Utils;

trait Fillable
{
    /**
     * Populates a object with provided data
     *
     * @param array $data
     *
     * @return $this
     */
    public function fill(array $data): self
    {
        foreach ($data as $key => $value) {
            $method = StringUtil::prefix('set', StringUtil::toCamelCase($key, '_'));
            if (method_exists($this, $method)) {
                call_user_func([$this, $method], $value);

                continue;
            }

            $property = StringUtil::toCamelCase($key);
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }

        return $this;
    }
}
