<?php

namespace Sakila\Test\Domain\Staff\Requests\Handlers;

use Sakila\Domain\Staff\Entity\Mapper\StaffMapper;
use Sakila\Domain\Staff\Entity\Transformer\StaffTransformerInterface;
use Sakila\Domain\Staff\Repository\StaffRepository;
use Sakila\Domain\Staff\Service\AddStaffService;
use Sakila\Domain\Staff\Service\Request\AddStaffRequest;
use Sakila\Domain\Staff\Service\Request\UpdateStaffRequest;
use Sakila\Domain\Staff\Service\UpdateStaffService;
use Sakila\Domain\Staff\Validator\StaffValidator;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;
use Sakila\Transformer\Transformer;

class StaffServiceTest extends AbstractIntegrationTestCase
{
    public function testAddStaff()
    {
        $request = new AddStaffRequest(['foo' => 'bar']);

        $validator = $this->createMock(StaffValidator::class);
        $validator->expects($this->once())->method('validate')->with($request->getAttributes());

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(StaffMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(StaffRepository::class);
        $repository->expects($this->once())->method('add')->with($mapped);
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $transformer = $this->createMock(Transformer::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, StaffTransformerInterface::class)
            ->willReturn($entity);

        $service = new AddStaffService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }

    public function testUpdateStaff()
    {
        $staffId = 1;
        $request = new UpdateStaffRequest($staffId, ['foo' => 'bar']);

        $attributes = array_merge(['staff_id' => $request->getStaffId()], $request->getAttributes());
        $validator  = $this->createMock(StaffValidator::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(StaffMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(StaffRepository::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($request->getStaffId(), $mapped)
            ->willReturn($entity);

        $transformer = $this->createMock(Transformer::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, StaffTransformerInterface::class)
            ->willReturn($entity);

        $service = new UpdateStaffService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }
}
