<?php declare(strict_types=1);

namespace Sakila\Test\Repository\Database;

use Sakila\Entity\EntityInterface;
use Sakila\Entity\FactoryInterface;
use Sakila\Exceptions\Database\NotFoundException;
use Sakila\Exceptions\Repository\RepositoryException;
use Sakila\Repository\Database\AbstractDatabaseRepository;
use Sakila\Repository\Database\ConnectionInterface;
use Sakila\Repository\Database\Query\BuilderInterface;
use Sakila\Repository\Database\Table\SimpleNameResolver;
use Sakila\Test\AbstractUnitTestCase;

class AbstractDatabaseRepositoryTest extends AbstractUnitTestCase
{
    public function testGetMethodThrowsExceptionWhenNoResults()
    {
        $this->expectException(NotFoundException::class);

        $connection = $this->createMock(ConnectionInterface::class);
        $cut        = $this->getCut($connection);

        $cut->get(1);
    }

    public function testGetMethod()
    {
        $data         = ['foo' => 'bar'];
        $queryBuilder = $this->createMock(BuilderInterface::class);
        $queryBuilder->method('select')->willReturnSelf();
        $queryBuilder->method('from')->with('foo')->willReturnSelf();
        $queryBuilder->method('where')->with(['id' => 1])->willReturnSelf();
        $queryBuilder->method('get')->willReturn([$data]);

        $entity        = $this->createMock(EntityInterface::class);
        $entityFactory = $this->createMock(FactoryInterface::class);
        $entityFactory->method('create')->with('foo', $data)->willReturn($entity);

        $connection = $this->createMock(ConnectionInterface::class);
        $connection->expects($this->once())->method('query')->willReturn($queryBuilder);

        $cut = $this->getCut($connection, $entityFactory);

        $this->assertEquals($entity, $cut->get(1));
    }

    public function testGetMethodReturnsDataWithoutUsingFactoryWhenEntityInterface()
    {
        $entity       = $this->createMock(EntityInterface::class);
        $queryBuilder = $this->createMock(BuilderInterface::class);
        $queryBuilder->method('select')->willReturnSelf();
        $queryBuilder->method('from')->with('foo')->willReturnSelf();
        $queryBuilder->method('where')->with(['id' => 1])->willReturnSelf();
        $queryBuilder->method('get')->willReturn([$entity]);

        $entityFactory = $this->createMock(FactoryInterface::class);
        $connection    = $this->createMock(ConnectionInterface::class);
        $connection->expects($this->once())->method('query')->willReturn($queryBuilder);

        $cut = $this->getCut($connection, $entityFactory);

        $this->assertEquals($entity, $cut->get(1));
    }

    public function testAllMethod()
    {
        $data         = ['foo' => 'bar'];
        $queryBuilder = $this->createMock(BuilderInterface::class);
        $queryBuilder->method('select')->willReturnSelf();
        $queryBuilder->method('from')->with('foo')->willReturnSelf();
        $queryBuilder->method('get')->willReturn($data);

        $entity        = $this->createMock(EntityInterface::class);
        $entityFactory = $this->createMock(FactoryInterface::class);
        $entityFactory->method('hydrate')->with('foo', $data)->willReturn([$entity]);

        $connection = $this->createMock(ConnectionInterface::class);
        $connection->expects($this->once())->method('query')->willReturn($queryBuilder);

        $cut = $this->getCut($connection, $entityFactory);

        $this->assertEquals([$entity], $cut->all());
    }

    public function testUpdateMethod()
    {
        $data         = ['foo' => 'bar'];
        $queryBuilder = $this->createMock(BuilderInterface::class);
        $queryBuilder->method('select')->willReturnSelf();
        $queryBuilder->method('from')->with('foo')->willReturnSelf();
        $queryBuilder->method('where')->with(['id' => 1])->willReturnSelf();
        $queryBuilder->method('get')->willReturn([$data]);

        $entity        = $this->createMock(EntityInterface::class);
        $entityFactory = $this->createMock(FactoryInterface::class);
        $entityFactory->method('create')->with('foo', $data)->willReturn($entity);

        $connection = $this->createMock(ConnectionInterface::class);
        $connection->expects($this->once())->method('update')->with('foo', $data, ['id' => 1]);
        $connection->expects($this->once())->method('query')->willReturn($queryBuilder);

        $cut = $this->getCut($connection, $entityFactory);

        $this->assertEquals($entity, $cut->update(1, $data));
    }

    public function testInsertMethod()
    {
        $value      = ['foo' => 'bar'];
        $connection = $this->createMock(ConnectionInterface::class);
        $connection
            ->expects($this->once())
            ->method('insert')
            ->with('foo', $value)
            ->willReturn(true);

        $cut = $this->getCut($connection);

        $this->assertTrue($cut->add($value));
    }

    public function testInsertMethodThrowsException()
    {
        $this->expectException(RepositoryException::class);

        $value      = ['foo' => 'bar'];
        $connection = $this->createMock(ConnectionInterface::class);
        $connection
            ->expects($this->once())
            ->method('insert')
            ->with('foo', $value)
            ->willReturn(false);

        $cut = $this->getCut($connection);

        $cut->add($value);
    }

    public function testRemoveMethod()
    {
        $connection = $this->createMock(ConnectionInterface::class);
        $connection
            ->expects($this->once())
            ->method('delete')
            ->with('foo', ['id' => 1])
            ->willReturn(true);

        $cut = $this->getCut($connection);

        $cut->remove(1);
    }

    public function testLastInsertedId()
    {
        $connection = $this->createMock(ConnectionInterface::class);
        $connection->expects($this->once())->method('lastInsertedId')->willReturn(1);

        $cut = $this->getCut($connection);

        $this->assertEquals(1, $cut->lastInsertedId());
    }

    public function testLastInsertedIdThrowsException()
    {
        $this->expectException(RepositoryException::class);

        $connection = $this->createMock(ConnectionInterface::class);
        $connection->expects($this->once())->method('lastInsertedId')->willReturn(0);

        $cut = $this->getCut($connection);

        $cut->lastInsertedId();
    }

    public function testCount()
    {
        $connection = $this->createMock(ConnectionInterface::class);
        $connection->expects($this->once())->method('count')->with('foo')->willReturn(0);

        $cut = $this->getCut($connection);

        $cut->count();
    }

    /**
     * @param                                               $connection
     * @param null|\PHPUnit\Framework\MockObject\MockObject $factory
     *
     * @return \PHPUnit\Framework\MockObject\MockObject|\Sakila\Repository\Database\AbstractDatabaseRepository
     */
    private function getCut($connection, $factory = null)
    {
        $factory = $factory ?? $this->createMock(FactoryInterface::class);

        return $this->getMockForAbstractClass(
            AbstractDatabaseRepository::class,
            [$connection, $factory, new SimpleNameResolver()],
            'FooRepository'
        );
    }
}
