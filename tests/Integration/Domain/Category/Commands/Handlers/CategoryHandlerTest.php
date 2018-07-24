<?php

namespace Sakila\Test\Domain\Category\Commands\Handlers;

use Sakila\Domain\Category\Commands\AddCategoryCommand;
use Sakila\Domain\Category\Commands\Handlers\CategoryHandler;
use Sakila\Domain\Category\Commands\UpdateCategoryCommand;
use Sakila\Domain\Category\Entity\Mapper\CategoryMapper;
use Sakila\Domain\Category\Repository\CategoryRepository;
use Sakila\Domain\Category\Validator\CategoryValidator;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;

class CategoryHandlerTest extends AbstractIntegrationTestCase
{
    public function testAddCategory()
    {
        $command = new AddCategoryCommand(['foo' => 'bar']);

        $validator = $this->createMock(CategoryValidator::class);
        $validator->expects($this->once())->method('validate')->with($command->getAttributes());

        $mapper = new CategoryMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(CategoryRepository::class);
        $repository->expects($this->once())->method('add')->with($mapper->map($command->getAttributes()));
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $handler = new CategoryHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleAddCategory($command));
    }

    public function testUpdateCategory()
    {
        $categoryId = 1;
        $command    = new UpdateCategoryCommand($categoryId, ['foo' => 'bar']);

        $attributes = array_merge(['category_id' => $command->getCategoryId()], $command->getAttributes());
        $validator  = $this->createMock(CategoryValidator::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $mapper = new CategoryMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(CategoryRepository::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($command->getCategoryId(), $mapper->map($command->getAttributes()))
            ->willReturn($entity);

        $handler = new CategoryHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleUpdateCategory($command));
    }
}
