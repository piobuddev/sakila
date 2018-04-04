<?php

namespace Sakila\Test\Repository\Database;

use Sakila\Entity\EntityInterface;
use Sakila\Entity\Factory;
use Sakila\Repository\Database\AbstractDatabaseRepository;
use Sakila\Repository\Database\ConnectionInterface;
use Sakila\Repository\Database\Query\BuilderInterface;
use Sakila\Test\AbstractUnitTestCase;

class AbstractDatabaseRepositoryTest extends AbstractUnitTestCase
{
    private const TEST_CLASS_NAME = 'TestRepository';

    private const ENTITY_ID = 1;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Sakila\Repository\Database\ConnectionInterface
     */
    private $connectionMock;

    /**
     * @var
     */
    private $testData;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Sakila\Entity\Factory
     */
    private $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Sakila\Entity\EntityInterface
     */
    private $entityMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Sakila\Repository\Database\AbstractDatabaseRepository
     */
    private $cut;

    /**
     * @var \Sakila\Repository\Database\Query\BuilderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $queryBuilder;

    protected function setUp()
    {
        parent::setUp();

        $this->testData       = ['foo' => 'baz'];

        $this->queryBuilder   = $this->createMock(BuilderInterface::class);
        $this->queryBuilder->method('from')->willReturnSelf();
        $this->queryBuilder->method('where')->willReturnSelf();
        $this->queryBuilder->method('get')->willReturn($this->testData);

        $this->connectionMock = $this->createMock(ConnectionInterface::class);
        $this->connectionMock->method('query')->willReturn($this->queryBuilder);

        $this->entityMock     = $this->createMock(EntityInterface::class);
        $this->factoryMock    = $this->createMock(Factory::class);
        $this->cut            = $this->getMockForAbstractClass(
            AbstractDatabaseRepository::class,
            [$this->connectionMock, $this->factoryMock],
            self::TEST_CLASS_NAME
        );
    }

    public function testGetMethodUseConnectionToFetchData()
    {
        $this->connectionMock->expects($this->once())->method('query')->willReturn($this->queryBuilder);

        $this->cut->get(self::ENTITY_ID);
    }

    public function testResolveTableNameFromClassName()
    {
        $tableName = strtolower(str_replace('Repository', '', self::TEST_CLASS_NAME));

        $this->queryBuilder->expects($this->once())->method('from')->with($tableName)->willReturnSelf();
        $this->connectionMock->expects($this->once())->method('query')->willReturn($this->queryBuilder);

        $this->cut->get(self::ENTITY_ID);
    }

    public function testReturnDataFromFactory()
    {
        $this->factoryMock->expects($this->once())->method('create')->willReturn($this->entityMock);

        $this->assertEquals($this->entityMock, $this->cut->get(self::ENTITY_ID));
    }

    public function testUseTableNameSetInConcreteClass()
    {
        $table = 'foo_table';
        $cut   = new \ReflectionClass($this->cut);

        $property = $cut->getProperty('table');
        $property->setAccessible(true);
        $property->setValue($this->cut, $table);

        $this->queryBuilder->expects($this->once())->method('from')->with($table)->willReturnSelf();

        $this->cut->get(self::ENTITY_ID);
    }

    public function testAllMethodUseConnectionToFetchAllData()
    {
        $this->queryBuilder->expects($this->once())->method('from')->willReturnSelf();
        $this->queryBuilder->expects($this->once())->method('get')->willReturn($this->testData);

        $this->cut->all();
    }

    public function testReturnsInstanceOfEntityInterface()
    {
        $this->markTestIncomplete('add integration');
    }
}
