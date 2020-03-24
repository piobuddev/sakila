<?php declare(strict_types=1);

namespace Sakila\Domain\Language\Service;

use Sakila\Domain\Language\Entity\Transformer\LanguageTransformerInterface;
use Sakila\Domain\Language\Repository\LanguageRepositoryInterface;
use Sakila\Domain\Language\Service\Request\ShowLanguageRequest;
use Sakila\Transformer\TransformerInterface;

class ShowLanguageService
{
    /**
     * @var \Sakila\Domain\Language\Repository\LanguageRepositoryInterface
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Language\Repository\LanguageRepositoryInterface $repository
     * @param \Sakila\Transformer\TransformerInterface                       $transformer
     */
    public function __construct(LanguageRepositoryInterface $repository, TransformerInterface $transformer)
    {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Language\Service\Request\ShowLanguageRequest $showLanguageRequest
     *
     * @return mixed
     */
    public function execute(ShowLanguageRequest $showLanguageRequest)
    {
        $language = $this->repository->get($showLanguageRequest->getLanguageId());

        return $this->transformer->item($language, LanguageTransformerInterface::class);
    }
}
