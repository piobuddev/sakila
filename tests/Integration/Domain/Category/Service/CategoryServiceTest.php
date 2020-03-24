<?php

namespace Sakila\Test\Domain\Category\Requests\Handlers;

use Sakila\Domain\Category\Entity\Mapper\CategoryMapper;
use Sakila\Domain\Category\Entity\Transformer\CategoryTransformerInterface;
use Sakila\Domain\Category\Repository\CategoryRepositoryInterface;
use Sakila\Domain\Category\Service\AddCategoryService;
use Sakila\Domain\Category\Service\Request\AddCategoryRequest;
use Sakila\Domain\Category\Service\Request\UpdateCategoryRequest;
use Sakila\Domain\Category\Service\UpdateCategoryService;
use Sakila\Domain\Category\Validator\CategoryValidatorInterface;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;
use Sakila\Transformer\TransformerInterface;

class CategoryServiceTest extends AbstractIntegrationTestCase
{
    public function testAddCategory()
    {
        $request = new AddCategoryRequest(['foo' => 'bar']);

        $validator = $this->createMock(CategoryValidatorInterface::class);
        $validator->expects($this->once())->method('validate')->with($request->getAttributes());

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(CategoryMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(CategoryRepositoryInterface::class);
        $repository->expects($this->once())->method('add')->with($mapped);
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $transformer = $this->createMock(TransformerInterface::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, CategoryTransformerInterface::class)
            ->willReturn($entity);

        $service = new AddCategoryService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }

    public function testUpdateCategory()
    {
        $categoryId = 1;
        $request = new UpdateCategoryRequest($categoryId, ['foo' => 'bar']);

        $attributes = array_merge(['category_id' => $request->getCategoryId()], $request->getAttributes());
        $validator  = $this->createMock(CategoryValidatorInterface::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(CategoryMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(CategoryRepositoryInterface::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($request->getCategoryId(), $mapped)
            ->willReturn($entity);

        $transformer = $this->createMock(TransformerInterface::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, CategoryTransformerInterface::class)
            ->willReturn($entity);

        $service = new UpdateCategoryService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }
}
