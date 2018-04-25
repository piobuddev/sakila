<?php declare(strict_types=1);

namespace Sakila\Domain\Category\Commands\Handlers;

use Sakila\Domain\Category\Commands\AddCategoryCommand;
use Sakila\Domain\Category\Commands\UpdateCategoryCommand;
use Sakila\Domain\Category\Entity\CategoryEntity;
use Sakila\Domain\Category\Entity\Mapper\CategoryMapper;
use Sakila\Domain\Category\Repository\CategoryRepository;
use Sakila\Domain\Category\Validator\CategoryValidator;
use Sakila\Exceptions\UnexpectedValueException;

class CategoryHandler
{
    /**
     * @var \Sakila\Domain\Category\Entity\Mapper\CategoryMapper
     */
    private $categoryMapper;

    /**
     * @var \Sakila\Domain\Category\Repository\CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var \Sakila\Domain\Category\Validator\CategoryValidator
     */
    private $validator;

    /**
     * @param \Sakila\Domain\Category\Entity\Mapper\CategoryMapper  $mapper
     * @param \Sakila\Domain\Category\Repository\CategoryRepository $repository
     * @param \Sakila\Domain\Category\Validator\CategoryValidator   $validator
     */
    public function __construct(CategoryMapper $mapper, CategoryRepository $repository, CategoryValidator $validator)
    {
        $this->categoryMapper     = $mapper;
        $this->categoryRepository = $repository;
        $this->validator       = $validator;
    }

    /**
     * @param \Sakila\Domain\Category\Commands\AddCategoryCommand $command
     *
     * @return \Sakila\Domain\Category\Entity\CategoryEntity
     * @throws \Sakila\Exceptions\UnexpectedValueException
     */
    public function handleAddCategory(AddCategoryCommand $command): CategoryEntity
    {
        $this->validator->validate($command->getAttributes());
        $this->categoryRepository->add($this->categoryMapper->map($command->getAttributes()));

        $categoryId = $this->categoryRepository->lastInsertedId();
        $category   = $this->categoryRepository->get($categoryId);
        if (!$category instanceof CategoryEntity) {
            throw new UnexpectedValueException();
        }

        return $category;
    }

    /**
     * @param \Sakila\Domain\Category\Commands\UpdateCategoryCommand $command
     *
     * @return \Sakila\Domain\Category\Entity\CategoryEntity
     * @throws \Sakila\Exceptions\Database\NotFoundException
     * @throws \Sakila\Exceptions\InvalidArgumentException
     * @throws \Sakila\Exceptions\SakilaException
     */
    public function handleUpdateCategory(UpdateCategoryCommand $command): CategoryEntity
    {
        $attributes = array_merge(['category_id' => $command->getCategoryId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->categoryRepository->update(
            $command->getCategoryId(),
            $this->categoryMapper->map($command->getAttributes())
        );
    }
}
