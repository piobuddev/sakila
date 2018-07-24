<?php declare(strict_types=1);

namespace Sakila\Domain\Language\Commands\Handlers;

use Sakila\Domain\Language\Commands\AddLanguageCommand;
use Sakila\Domain\Language\Commands\UpdateLanguageCommand;
use Sakila\Domain\Language\Entity\Mapper\LanguageMapper;
use Sakila\Domain\Language\Repository\LanguageRepository;
use Sakila\Domain\Language\Validator\LanguageValidator;
use Sakila\Entity\EntityInterface;

class LanguageHandler
{
    /**
     * @var \Sakila\Domain\Language\Entity\Mapper\LanguageMapper
     */
    private $languageMapper;

    /**
     * @var \Sakila\Domain\Language\Repository\LanguageRepository
     */
    private $languageRepository;

    /**
     * @var \Sakila\Domain\Language\Validator\LanguageValidator
     */
    private $validator;

    /**
     * @param \Sakila\Domain\Language\Entity\Mapper\LanguageMapper  $mapper
     * @param \Sakila\Domain\Language\Repository\LanguageRepository $repository
     * @param \Sakila\Domain\Language\Validator\LanguageValidator   $validator
     */
    public function __construct(LanguageMapper $mapper, LanguageRepository $repository, LanguageValidator $validator)
    {
        $this->languageMapper     = $mapper;
        $this->languageRepository = $repository;
        $this->validator          = $validator;
    }

    /**
     * @param \Sakila\Domain\Language\Commands\AddLanguageCommand $command
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function handleAddLanguage(AddLanguageCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->languageRepository->add($this->languageMapper->map($command->getAttributes()));

        $languageId = $this->languageRepository->lastInsertedId();
        $language   = $this->languageRepository->get($languageId);

        return $language;
    }

    /**
     * @param \Sakila\Domain\Language\Commands\UpdateLanguageCommand $command
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function handleUpdateLanguage(UpdateLanguageCommand $command): EntityInterface
    {
        $attributes = array_merge(['language_id' => $command->getLanguageId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->languageRepository->update(
            $command->getLanguageId(),
            $this->languageMapper->map($command->getAttributes())
        );
    }
}
