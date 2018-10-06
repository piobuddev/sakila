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

    public function execute(RemoveLanguageRequest $removeLanguageRequest)
    {
        return $this->repository->remove($removeLanguageRequest->getLanguageId());
    }
}
