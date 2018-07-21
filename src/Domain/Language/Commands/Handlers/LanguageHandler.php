<?php declare(strict_types=1);

namespace Sakila\Domain\Language\Commands\Handlers;

use Sakila\Domain\Language\Commands\AddLanguageCommand;
use Sakila\Domain\Language\Commands\UpdateLanguageCommand;
use Sakila\Domain\Language\Entity\LanguageEntity;
use Sakila\Domain\Language\Entity\Mapper\LanguageMapper;
use Sakila\Domain\Language\Repository\LanguageRepository;
use Sakila\Domain\Language\Validator\LanguageValidator;
use Sakila\Exceptions\UnexpectedValueException;

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
     * @return \Sakila\Domain\Language\Entity\LanguageEntity
     * @throws \Sakila\Exceptions\UnexpectedValueException
     */
    public function handleAddLanguage(AddLanguageCommand $command): LanguageEntity
    {
        $this->validator->validate($command->getAttributes());
        $this->languageRepository->add($this->languageMapper->map($command->getAttributes()));

        $languageId = $this->languageRepository->lastInsertedId();
        $language   = $this->languageRepository->get($languageId);
        if (!$language instanceof LanguageEntity) {
            throw new UnexpectedValueException();
        }

        return $language;
    }

    /**
     * @param \Sakila\Domain\Language\Commands\UpdateLanguageCommand $command
     *
     * @return \Sakila\Domain\Language\Entity\LanguageEntity
     */
    public function handleUpdateLanguage(UpdateLanguageCommand $command): LanguageEntity
    {
        $attributes = array_merge(['language_id' => $command->getLanguageId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->languageRepository->update(
            $command->getLanguageId(),
            $this->languageMapper->map($command->getAttributes())
        );
    }
}
