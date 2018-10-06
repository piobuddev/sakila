<?php declare(strict_types=1);

namespace Sakila\Domain\Film\Service;

use Sakila\Domain\Film\Entity\Mapper\FilmMapper;
use Sakila\Domain\Film\Entity\Transformer\FilmTransformerInterface;
use Sakila\Domain\Film\Repository\FilmRepository;
use Sakila\Domain\Film\Service\Request\UpdateFilmRequest;
use Sakila\Domain\Film\Validator\FilmValidator;
use Sakila\Transformer\Transformer;

class UpdateFilmService
{
    /**
     * @var \Sakila\Domain\Film\Validator\FilmValidator
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Film\Repository\FilmRepository
     */
    private $filmRepository;

    /**
     * @var \Sakila\Domain\Film\Entity\Mapper\FilmMapper
     */
    private $filmMapper;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Film\Validator\FilmValidator   $validator
     * @param \Sakila\Domain\Film\Repository\FilmRepository $repository
     * @param \Sakila\Domain\Film\Entity\Mapper\FilmMapper  $filmMapper
     * @param \Sakila\Transformer\Transformer               $transformer
     */
    public function __construct(
        FilmValidator $validator,
        FilmRepository $repository,
        FilmMapper $filmMapper,
        Transformer $transformer
    ) {
        $this->validator      = $validator;
        $this->filmRepository = $repository;
        $this->filmMapper     = $filmMapper;
        $this->transformer    = $transformer;
    }

    /**
     * @param \Sakila\Domain\Film\Service\Request\UpdateFilmRequest $updateFilmRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(UpdateFilmRequest $updateFilmRequest)
    {
        $this->validator->validate(
            array_merge(
                ['film_id' => $updateFilmRequest->getFilmId()],
                $updateFilmRequest->getAttributes()
            )
        );

        $film = $this->filmRepository->update(
            $updateFilmRequest->getFilmId(),
            $this->filmMapper->map($updateFilmRequest->getAttributes())
        );

        return $this->transformer->item($film, FilmTransformerInterface::class);
    }
}
