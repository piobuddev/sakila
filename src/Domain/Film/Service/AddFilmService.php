<?php declare(strict_types=1);

namespace Sakila\Domain\Film\Service;

use Sakila\Domain\Film\Entity\Mapper\FilmMapper;
use Sakila\Domain\Film\Entity\Transformer\FilmTransformerInterface;
use Sakila\Domain\Film\Repository\FilmRepository;
use Sakila\Domain\Film\Service\Request\AddFilmRequest;
use Sakila\Domain\Film\Validator\FilmValidator;
use Sakila\Transformer\Transformer;

class AddFilmService
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
     * @param \Sakila\Domain\Film\Service\Request\AddFilmRequest $addFilmRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(AddFilmRequest $addFilmRequest)
    {
        $this->validator->validate($addFilmRequest->getAttributes());
        $this->filmRepository->add($this->filmMapper->map($addFilmRequest->getAttributes()));

        $filmId = $this->filmRepository->lastInsertedId();
        $film   = $this->filmRepository->get($filmId);

        return $this->transformer->item($film, FilmTransformerInterface::class);
    }
}
