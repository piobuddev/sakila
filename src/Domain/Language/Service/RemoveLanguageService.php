<?php declare(strict_types=1);

namespace Sakila\Domain\Language\Service;

use Sakila\Domain\Language\Repository\LanguageRepositoryInterface;
use Sakila\Domain\Language\Service\Request\RemoveLanguageRequest;

class RemoveLanguageService
{
    /**
     * @var \Sakila\Domain\Language\Repository\LanguageRepositoryInterface
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Language\Repository\LanguageRepositoryInterface $repository
     */
    public function __construct(LanguageRepositoryInterface $repository)
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
