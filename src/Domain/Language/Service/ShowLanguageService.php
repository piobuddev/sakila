<?php declare(strict_types=1);

namespace Sakila\Domain\Language\Service;

use Sakila\Domain\Language\Entity\Transformer\LanguageTransformerInterface;
use Sakila\Domain\Language\Repository\LanguageRepository;
use Sakila\Domain\Language\Service\Request\ShowLanguageRequest;
use Sakila\Transformer\Transformer;

class ShowLanguageService
{
    /**
     * @var \Sakila\Domain\Language\Repository\LanguageRepository
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Language\Repository\LanguageRepository $repository
     * @param \Sakila\Transformer\Transformer                       $transformer
     */
    public function __construct(LanguageRepository $repository, Transformer $transformer)
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
