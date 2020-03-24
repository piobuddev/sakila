<?php

namespace Sakila\Test\Domain\Language\Requests\Handlers;

use Sakila\Domain\Language\Entity\Mapper\LanguageMapper;
use Sakila\Domain\Language\Entity\Transformer\LanguageTransformerInterface;
use Sakila\Domain\Language\Repository\LanguageRepositoryInterface;
use Sakila\Domain\Language\Service\AddLanguageService;
use Sakila\Domain\Language\Service\Request\AddLanguageRequest;
use Sakila\Domain\Language\Service\Request\UpdateLanguageRequest;
use Sakila\Domain\Language\Service\UpdateLanguageService;
use Sakila\Domain\Language\Validator\LanguageValidatorInterface;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;
use Sakila\Transformer\TransformerInterface;

class LanguageServiceTest extends AbstractIntegrationTestCase
{
    public function testAddLanguage()
    {
        $request = new AddLanguageRequest(['foo' => 'bar']);

        $validator = $this->createMock(LanguageValidatorInterface::class);
        $validator->expects($this->once())->method('validate')->with($request->getAttributes());

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(LanguageMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(LanguageRepositoryInterface::class);
        $repository->expects($this->once())->method('add')->with($mapped);
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $transformer = $this->createMock(TransformerInterface::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, LanguageTransformerInterface::class)
            ->willReturn($entity);

        $service = new AddLanguageService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }

    public function testUpdateLanguage()
    {
        $languageId = 1;
        $request = new UpdateLanguageRequest($languageId, ['foo' => 'bar']);

        $attributes = array_merge(['language_id' => $request->getLanguageId()], $request->getAttributes());
        $validator  = $this->createMock(LanguageValidatorInterface::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(LanguageMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(LanguageRepositoryInterface::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($request->getLanguageId(), $mapped)
            ->willReturn($entity);

        $transformer = $this->createMock(TransformerInterface::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, LanguageTransformerInterface::class)
            ->willReturn($entity);

        $service = new UpdateLanguageService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }
}
