<?php declare(strict_types=1);

namespace Sakila\Entity\Mapper;

abstract class AbstractMapper
{
    /**
     * @return array
     */
    abstract protected function getMapping(): array;

    /**
     * @param array $attributes
     *
     * @return array
     */
    public function map(array $attributes): array
    {
        $mapping = $this->getMapping();
        $result  = $attributes;
        foreach ($attributes as $key => $value) {
            if (array_key_exists($key, $mapping)) {
                $result[$mapping[$key]] = $value;
                unset($result[$key]);
            }
        }

        return $result;
    }
}
