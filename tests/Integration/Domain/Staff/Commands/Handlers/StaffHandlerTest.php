<?php

namespace Sakila\Test\Domain\Staff\Commands\Handlers;

use Sakila\Domain\Staff\Commands\AddStaffCommand;
use Sakila\Domain\Staff\Commands\Handlers\StaffHandler;
use Sakila\Domain\Staff\Commands\UpdateStaffCommand;
use Sakila\Domain\Staff\Entity\Mapper\StaffMapper;
use Sakila\Domain\Staff\Repository\StaffRepository;
use Sakila\Domain\Staff\Validator\StaffValidator;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;

class StaffHandlerTest extends AbstractIntegrationTestCase
{
    public function testAddStaff()
    {
        $command = new AddStaffCommand(['foo' => 'bar']);

        $validator = $this->createMock(StaffValidator::class);
        $validator->expects($this->once())->method('validate')->with($command->getAttributes());

        $mapper = new StaffMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(StaffRepository::class);
        $repository->expects($this->once())->method('add')->with($mapper->map($command->getAttributes()));
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $handler = new StaffHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleAddStaff($command));
    }

    public function testUpdateStaff()
    {
        $staffId = 1;
        $command = new UpdateStaffCommand($staffId, ['foo' => 'bar']);

        $attributes = array_merge(['staff_id' => $command->getStaffId()], $command->getAttributes());
        $validator  = $this->createMock(StaffValidator::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $mapper = new StaffMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(StaffRepository::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($command->getStaffId(), $mapper->map($command->getAttributes()))
            ->willReturn($entity);

        $handler = new StaffHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleUpdateStaff($command));
    }
}
