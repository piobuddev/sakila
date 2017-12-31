<?php declare(strict_types=1);

namespace Sakila\Test\Repository\Database\Table;

use Sakila\Repository\Database\Table\Table;
use Sakila\Repository\Database\Table\TableInterface;
use Sakila\Test\AbstractUnitTestCase;

class TableTest extends AbstractUnitTestCase
{
    public function testImplementsTableInterface()
    {
        $this->assertInstanceOf(TableInterface::class, new Table('foo'));
    }

    public function testReturnDefaultPrimaryKey()
    {
        $this->assertEquals('id', (new Table('foo'))->getPrimaryKey());
    }

    public function testReturnExpectedTableNameAndPrimaryKey()
    {
        $cut = new Table('foo', 'foo_pk');

        $this->assertEquals('foo', $cut->getName());
        $this->assertEquals('foo_pk', $cut->getPrimaryKey());
    }
}
