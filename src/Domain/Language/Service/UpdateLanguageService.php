<?php declare(strict_types=1);

namespace Sakila\Domain\Language\Service;

use Sakila\Domain\Language\Entity\Mapper\LanguageMapper;
use Sakila\Domain\Language\Entity\Transformer\LanguageTransformerInterface;
use Sakila\Domain\Language\Repository\LanguageRepository;
use Sakila\Domain\Language\Service\Request\UpdateLanguageRequest;
use Sakila\Domain\Language\Validator\LanguageValidator;
use Sakila\Transformer\Transformer;

class UpdateLanguageService
{
    /**
     * @var \Sakila\Domain\Language\Validator\LanguageValidator
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Language\Repository\LanguageRepository
     */
    private $languageRepository;

    /**
     * @var \Sakila\Domain\Language\Entity\Mapper\LanguageMapper
     */
    private $languageMapper;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Language\Validator\LanguageValidator   $validator
     * @param \Sakila\Domain\Language\Repository\LanguageRepository $repository
     * @param \Sakila\Domain\Language\Entity\Mapper\LanguageMapper  $languageMapper
     * @param \Sakila\Transformer\Transformer                       $transformer
     */
    public function __construct(
        LanguageValidator $validator,
        LanguageRepository $repository,
        LanguageMapper $languageMapper,
        Transformer $transformer
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
