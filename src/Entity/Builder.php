<?php declare(strict_types=1);

namespace Sakila\Entity;

use Sakila\Builder\BuilderInterface;
use Sakila\Exceptions\InvalidArgumentException;

class Builder implements BuilderInterface
{
    /**
     * @param string $entity
     * @param array  $data
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\InvalidArgumentException
     */
    public function build($entity, $data = []): EntityInterface
    {
        return $this->getEntity($entity)->fill($data);
    }

    /**
     * @param string $entityClassName
     *
     * @return \Sakila\Entity\AbstractEntity
     * @throws \Sakila\Exceptions\InvalidArgumentException
     */
    private function getEntity(string $entityClassName): AbstractEntity
    {
        if (!class_exists($entityClassName)) {
            throw new InvalidArgumentException('Class `%s` does not exist', $entityClassName);
        }

        $entity = new $entityClassName;
        if (!$entity instanceof AbstractEntity) {
            throw new InvalidArgumentException('Entity class has to extend `%s`', AbstractEntity::class);
        }

        return $entity;
    }
}
