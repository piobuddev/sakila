<?php

namespace Sakila\Test\Repository\Database;

use Sakila\Entity\EntityInterface;
use Sakila\Entity\Factory;
use Sakila\Repository\Database\AbstractDatabaseRepository;
use Sakila\Repository\Database\ConnectionInterface;
use Sakila\Repository\Database\Table\Table;
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

    public function testGetMethodUseConnectionToFetchData()
    {
        $this->connectionMock->expects($this->once())->method('fetch')->willReturn([]);

        $this->cut->get(self::ENTITY_ID);
    }

    public function testResolveTableNameFromClassName()
    {
        $tableName = strtolower(str_replace('Repository', '', self::TEST_CLASS_NAME));
        $table     = new Table($tableName);

        $this->connectionMock
            ->expects($this->once())
            ->method('fetch')
            ->with($table, self::ENTITY_ID)
            ->willReturn([]);

        $this->cut->get(self::ENTITY_ID);
    }

    public function testReturnDataFromFactory()
    {
        $this->connectionMock->method('fetch')->willReturn([]);
        $this->factoryMock->expects($this->once())->method('create')->willReturn($this->entityMock);

        $this->assertEquals($this->entityMock, $this->cut->get(self::ENTITY_ID));
    }

    public function testUseTableNameSetInConcreteClass()
    {
        $table = new Table('test_table');
        $cut   = new \ReflectionClass($this->cut);

        $property = $cut->getProperty('table');
        $property->setAccessible(true);
        $property->setValue($this->cut, $table->getName());

        $this->connectionMock
            ->expects($this->once())
            ->method('fetch')
            ->with($table, self::ENTITY_ID)
            ->willReturn([]);

        $this->cut->get(self::ENTITY_ID);
    }
}
