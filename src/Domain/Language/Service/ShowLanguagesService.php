<?php declare(strict_types=1);

namespace Sakila\Domain\Language\Service;

use Sakila\Domain\Language\Entity\Transformer\LanguageTransformerInterface;
use Sakila\Domain\Language\Repository\LanguageRepositoryInterface;
use Sakila\Domain\Language\Service\Request\ShowLanguagesRequest;
use Sakila\Transformer\TransformerInterface;

class ShowLanguagesService
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
    public function __construct(
        LanguageRepositoryInterface $repository,
        TransformerInterface $transformer
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
