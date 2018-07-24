<?php

namespace Sakila\Test\Domain\Language\Commands\Handlers;

use Sakila\Domain\Language\Commands\AddLanguageCommand;
use Sakila\Domain\Language\Commands\Handlers\LanguageHandler;
use Sakila\Domain\Language\Commands\UpdateLanguageCommand;
use Sakila\Domain\Language\Entity\Mapper\LanguageMapper;
use Sakila\Domain\Language\Repository\LanguageRepository;
use Sakila\Domain\Language\Validator\LanguageValidator;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;

class LanguageHandlerTest extends AbstractIntegrationTestCase
{
    public function testAddLanguage()
    {
        $command = new AddLanguageCommand(['foo' => 'bar']);

        $validator = $this->createMock(LanguageValidator::class);
        $validator->expects($this->once())->method('validate')->with($command->getAttributes());

        $mapper = new LanguageMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(LanguageRepository::class);
        $repository->expects($this->once())->method('add')->with($mapper->map($command->getAttributes()));
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $handler = new LanguageHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleAddLanguage($command));
    }

    public function testUpdateLanguage()
    {
        $languageId = 1;
        $command    = new UpdateLanguageCommand($languageId, ['foo' => 'bar']);

        $attributes = array_merge(['language_id' => $command->getLanguageId()], $command->getAttributes());
        $validator  = $this->createMock(LanguageValidator::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $mapper = new LanguageMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(LanguageRepository::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($command->getLanguageId(), $mapper->map($command->getAttributes()))
            ->willReturn($entity);

        $handler = new LanguageHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleUpdateLanguage($command));
    }
}
