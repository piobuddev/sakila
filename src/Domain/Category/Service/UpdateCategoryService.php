<?php declare(strict_types=1);

namespace Sakila\Domain\Category\Service;

use Sakila\Domain\Category\Entity\Mapper\CategoryMapper;
use Sakila\Domain\Category\Entity\Transformer\CategoryTransformerInterface;
use Sakila\Domain\Category\Repository\CategoryRepositoryInterface;
use Sakila\Domain\Category\Service\Request\UpdateCategoryRequest;
use Sakila\Domain\Category\Validator\CategoryValidatorInterface;
use Sakila\Transformer\TransformerInterface;

class UpdateCategoryService
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
     * @param \Sakila\Domain\Category\Service\Request\UpdateCategoryRequest $updateCategoryRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(UpdateCategoryRequest $updateCategoryRequest)
    {
        $this->validator->validate(
            array_merge(
                ['category_id' => $updateCategoryRequest->getCategoryId()],
                $updateCategoryRequest->getAttributes()
            )
        );

        $category = $this->categoryRepository->update(
            $updateCategoryRequest->getCategoryId(),
            $this->categoryMapper->map($updateCategoryRequest->getAttributes())
        );

        return $this->transformer->item($category, CategoryTransformerInterface::class);
    }
}
