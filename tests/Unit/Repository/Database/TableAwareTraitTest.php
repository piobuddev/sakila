<?php declare(strict_types=1);

namespace Sakila\Test\Repository\Database;

use Sakila\Repository\Database\TableAwareTrait;
use Sakila\Test\AbstractUnitTestCase;

class TableAwareTraitTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedTableName()
    {
        /** @var TableAwareTrait|\PHPUnit\Framework\MockObject\MockObject $cut */
        $cut = $this->getMockForTrait(TableAwareTrait::class, [], 'FooRepository', false);

        $this->assertEquals('foo', $cut->getTableName());
    }
}
