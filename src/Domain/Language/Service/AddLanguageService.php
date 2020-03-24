<?php declare(strict_types=1);

namespace Sakila\Domain\Language\Service;

use Sakila\Domain\Language\Entity\Mapper\LanguageMapper;
use Sakila\Domain\Language\Entity\Transformer\LanguageTransformerInterface;
use Sakila\Domain\Language\Repository\LanguageRepositoryInterface;
use Sakila\Domain\Language\Service\Request\AddLanguageRequest;
use Sakila\Domain\Language\Validator\LanguageValidatorInterface;
use Sakila\Transformer\TransformerInterface;

class AddLanguageService
{
    /**
     * @var \Sakila\Domain\Language\Validator\LanguageValidatorInterface
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Language\Repository\LanguageRepositoryInterface
     */
    private $languageRepository;

    /**
     * @var \Sakila\Domain\Language\Entity\Mapper\LanguageMapper
     */
    private $languageMapper;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Language\Validator\LanguageValidatorInterface   $validator
     * @param \Sakila\Domain\Language\Repository\LanguageRepositoryInterface $repository
     * @param \Sakila\Domain\Language\Entity\Mapper\LanguageMapper           $languageMapper
     * @param \Sakila\Transformer\TransformerInterface                       $transformer
     */
    public function __construct(
        LanguageValidatorInterface $validator,
        LanguageRepositoryInterface $repository,
        LanguageMapper $languageMapper,
        TransformerInterface $transformer
    ) {
        $this->validator          = $validator;
        $this->languageRepository = $repository;
        $this->languageMapper     = $languageMapper;
        $this->transformer        = $transformer;
    }

    /**
     * @param \Sakila\Domain\Language\Service\Request\AddLanguageRequest $addLanguageRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(AddLanguageRequest $addLanguageRequest)
    {
        $this->validator->validate($addLanguageRequest->getAttributes());
        $this->languageRepository->add($this->languageMapper->map($addLanguageRequest->getAttributes()));

        $languageId = $this->languageRepository->lastInsertedId();
        $language   = $this->languageRepository->get($languageId);

        return $this->transformer->item($language, LanguageTransformerInterface::class);
    }
}
