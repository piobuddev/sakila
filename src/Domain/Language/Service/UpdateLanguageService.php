<?php declare(strict_types=1);

namespace Sakila\Domain\Language\Service;

use Sakila\Domain\Language\Entity\Mapper\LanguageMapper;
use Sakila\Domain\Language\Entity\Transformer\LanguageTransformerInterface;
use Sakila\Domain\Language\Repository\LanguageRepositoryInterface;
use Sakila\Domain\Language\Service\Request\UpdateLanguageRequest;
use Sakila\Domain\Language\Validator\LanguageValidatorInterface;
use Sakila\Transformer\TransformerInterface;

class UpdateLanguageService
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
     * @param \Sakila\Domain\Language\Service\Request\UpdateLanguageRequest $updateLanguageRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(UpdateLanguageRequest $updateLanguageRequest)
    {
        $this->validator->validate(
            array_merge(
                ['language_id' => $updateLanguageRequest->getLanguageId()],
                $updateLanguageRequest->getAttributes()
            )
        );

        $language = $this->languageRepository->update(
            $updateLanguageRequest->getLanguageId(),
            $this->languageMapper->map($updateLanguageRequest->getAttributes())
        );

        return $this->transformer->item($language, LanguageTransformerInterface::class);
    }
}
