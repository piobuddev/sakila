<?php

namespace Sakila\Test\Repository\Database;

use Sakila\Entity\EntityInterface;
use Sakila\Entity\Factory;
use Sakila\Repository\ConnectionInterface;
use Sakila\Repository\Database\AbstractDatabaseRepository;
use Sakila\Test\AbstractUnitTestCase;

class AbstractDatabaseRepositoryTest extends AbstractUnitTestCase
{
    private const TEST_CLASS_NAME = 'TestRepository';

    private const ENTITY_ID = 1;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Sakila\Repository\ConnectionInterface
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

    protected function setUp()
    {
        parent::setUp();

        $this->testData       = ['foo' => 'baz'];
        $this->connectionMock = $this->createMock(ConnectionInterface::class);
        $this->entityMock     = $this->createMock(EntityInterface::class);
        $this->factoryMock    = $this->createMock(Factory::class);
        $this->cut            = $this->getMockForAbstractClass(
            AbstractDatabaseRepository::class,
            [$this->connectionMock, $this->factoryMock],
            self::TEST_CLASS_NAME
        );
    }

    public function testUseConnectionToFetchData()
    {
        $this->connectionMock->expects($this->once())->method('get')->willReturn([]);

        $this->cut->find(self::ENTITY_ID);
    }

    public function testResolveTableNameFromClassName()
    {
        $tableName = strtolower(str_replace('Repository', '', self::TEST_CLASS_NAME));

        $this->connectionMock
            ->expects($this->once())
            ->method('get')
            ->with($tableName, self::ENTITY_ID)
            ->willReturn([]);

        $this->cut->find(self::ENTITY_ID);
    }

    public function testReturnDataFromFactory()
    {
        $this->connectionMock->method('get')->willReturn([]);
        $this->factoryMock->expects($this->once())->method('create')->willReturn($this->entityMock);

        $this->assertEquals($this->entityMock, $this->cut->find(self::ENTITY_ID));
    }

    public function testUseTableNameSetInConcreteClass()
    {
        $tableName = 'test_table';
        $cut       = new \ReflectionClass($this->cut);

        $property = $cut->getProperty('table');
        $property->setAccessible(true);
        $property->setValue($this->cut, $tableName);

        $this->connectionMock
            ->expects($this->once())
            ->method('get')
            ->with($tableName, self::ENTITY_ID)
            ->willReturn([]);

        $this->cut->find(self::ENTITY_ID);
    }
}
