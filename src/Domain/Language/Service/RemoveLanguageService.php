<?php declare(strict_types=1);

namespace Sakila\Domain\Language\Service;

use Sakila\Domain\Language\Repository\LanguageRepository;
use Sakila\Domain\Language\Service\Request\RemoveLanguageRequest;

class RemoveLanguageService
{
    /**
     * @var \Sakila\Domain\Language\Repository\LanguageRepository
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Language\Repository\LanguageRepository $repository
     */
    public function __construct(LanguageRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Sakila\Domain\Language\Service\Request\RemoveLanguageRequest $removeLanguageRequest
     *
     * @return bool
     */
    public function execute(RemoveLanguageRequest $removeLanguageRequest): bool
    {
        return $this->repository->remove($removeLanguageRequest->getLanguageId());
    }
}
