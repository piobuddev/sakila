<?php declare(strict_types=1);

namespace Sakila\Domain\Language\Service;

use Sakila\Domain\Language\Entity\Transformer\LanguageTransformerInterface;
use Sakila\Domain\Language\Repository\LanguageRepository;
use Sakila\Domain\Language\Service\Request\ShowLanguagesRequest;
use Sakila\Transformer\Transformer;

class ShowLanguagesService
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
    public function __construct(
        LanguageRepository $repository,
        Transformer $transformer
    ) {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Language\Service\Request\ShowLanguagesRequest $showLanguagesRequest
     *
     * @return mixed
     */
    public function execute(ShowLanguagesRequest $showLanguagesRequest)
    {
        $page      = $showLanguagesRequest->getPage();
        $pageSize  = $showLanguagesRequest->getPageSize();
        $languages = $this->repository->all($page, $pageSize);
        $total     = $this->repository->count();

        return $this->transformer->collection(
            $languages,
            LanguageTransformerInterface::class,
            $page,
            $pageSize,
            $total
        );
    }
}
