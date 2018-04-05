<?php

namespace Sakila\Test\Entity\Mapper;

use Sakila\Entity\Mapper\AbstractMapper;
use Sakila\Test\AbstractUnitTestCase;

class AbstractMapperTest extends AbstractUnitTestCase
{
    public function testMap()
    {
        $mapping = ['foo' => 'bar'];
        /** @var \PHPUnit\Framework\MockObject\MockObject|AbstractMapper $cut */
        $cut     = $this->getMockForAbstractClass(AbstractMapper::class);
        $cut->expects($this->once())->method('getMapping')->willReturn($mapping);

        $result = $cut->map(['foo' => 1, 'baz' => 2]);

        $this->assertArrayHasKey('bar', $result);
        $this->assertEquals(1, $result['bar']);
        $this->assertEquals(2, $result['baz']);
    }
}
