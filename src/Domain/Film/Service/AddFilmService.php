<?php declare(strict_types=1);

namespace Sakila\Domain\Film\Service;

use Sakila\Domain\Film\Entity\Mapper\FilmMapper;
use Sakila\Domain\Film\Entity\Transformer\FilmTransformerInterface;
use Sakila\Domain\Film\Repository\FilmRepositoryInterface;
use Sakila\Domain\Film\Service\Request\AddFilmRequest;
use Sakila\Domain\Film\Validator\FilmValidatorInterface;
use Sakila\Transformer\TransformerInterface;

class AddFilmService
{
    /**
     * @var \Sakila\Domain\Film\Validator\FilmValidatorInterface
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Film\Repository\FilmRepositoryInterface
     */
    private $filmRepository;

    /**
     * @var \Sakila\Domain\Film\Entity\Mapper\FilmMapper
     */
    private $filmMapper;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Film\Validator\FilmValidatorInterface   $validator
     * @param \Sakila\Domain\Film\Repository\FilmRepositoryInterface $repository
     * @param \Sakila\Domain\Film\Entity\Mapper\FilmMapper           $filmMapper
     * @param \Sakila\Transformer\TransformerInterface               $transformer
     */
    public function __construct(
        FilmValidatorInterface $validator,
        FilmRepositoryInterface $repository,
        FilmMapper $filmMapper,
        TransformerInterface $transformer
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
