<?php declare(strict_types=1);

namespace Sakila\Domain\Category\Service;

use Sakila\Domain\Category\Entity\Mapper\CategoryMapper;
use Sakila\Domain\Category\Entity\Transformer\CategoryTransformerInterface;
use Sakila\Domain\Category\Repository\CategoryRepositoryInterface;
use Sakila\Domain\Category\Service\Request\AddCategoryRequest;
use Sakila\Domain\Category\Validator\CategoryValidatorInterface;
use Sakila\Transformer\TransformerInterface;

class AddCategoryService
{
    /**
     * @var \Sakila\Domain\Category\Validator\CategoryValidatorInterface
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Category\Repository\CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var \Sakila\Domain\Category\Entity\Mapper\CategoryMapper
     */
    private $categoryMapper;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Category\Validator\CategoryValidatorInterface   $validator
     * @param \Sakila\Domain\Category\Repository\CategoryRepositoryInterface $repository
     * @param \Sakila\Domain\Category\Entity\Mapper\CategoryMapper           $categoryMapper
     * @param \Sakila\Transformer\TransformerInterface                       $transformer
     */
    public function __construct(
        CategoryValidatorInterface $validator,
        CategoryRepositoryInterface $repository,
        CategoryMapper $categoryMapper,
        TransformerInterface $transformer
    ) {
        $this->validator          = $validator;
        $this->categoryRepository = $repository;
        $this->categoryMapper     = $categoryMapper;
        $this->transformer        = $transformer;
    }

    /**
     * @param \Sakila\Domain\Category\Service\Request\AddCategoryRequest $addCategoryRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(AddCategoryRequest $addCategoryRequest)
    {
        $this->validator->validate($addCategoryRequest->getAttributes());
        $this->categoryRepository->add($this->categoryMapper->map($addCategoryRequest->getAttributes()));

        $categoryId = $this->categoryRepository->lastInsertedId();
        $category   = $this->categoryRepository->get($categoryId);

        return $this->transformer->item($category, CategoryTransformerInterface::class);
    }
}
