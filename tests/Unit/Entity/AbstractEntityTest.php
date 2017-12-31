<?php

namespace Sakila\Test\Entity;

use Sakila\Entity\AbstractEntity;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractUnitTestCase;

class AbstractEntityTest extends AbstractUnitTestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Sakila\Entity\AbstractEntity
     */
    private $cut;

    protected function setUp()
    {
        parent::setUp();

        $this->cut = $this->getMockForAbstractClass(AbstractEntity::class);
    }

    public function testInstanceOfEntityInterface()
    {
        $this->assertInstanceOf(EntityInterface::class, $this->cut);
    }

    public function testSerializableUsingProperties()
    {
        $this->cut->foo = 1;
        $this->cut->bar = 2;
        $this->cut->baz = 3;

        $data = $this->cut->jsonSerialize();

        $this->assertArrayHasKey('foo', $data);
        $this->assertArrayHasKey('bar', $data);
        $this->assertArrayHasKey('baz', $data);

        $this->assertEquals(1, $data['foo']);
        $this->assertEquals(2, $data['bar']);
        $this->assertEquals(3, $data['baz']);
    }

    public function testSerializableUsingGetters()
    {
        $methods = ['getFoo', 'getBar', 'getBaz'];
        /** @var AbstractEntity|\PHPUnit\Framework\MockObject\MockObject $cut */
        $cut     = $this->getMockForAbstractClass(AbstractEntity::class, [], '', true, true, true, $methods);

        $cut->foo = 1;
        $cut->bar = 2;
        $cut->baz = 3;

        $cut->expects($this->once())->method('getFoo')->willReturn(11);
        $cut->expects($this->once())->method('getBar')->willReturn(22);
        $cut->expects($this->once())->method('getBaz')->willReturn(33);

        $data = $cut->jsonSerialize();

        $this->assertArrayHasKey('foo', $data);
        $this->assertArrayHasKey('bar', $data);
        $this->assertArrayHasKey('baz', $data);

        $this->assertEquals(11, $data['foo']);
        $this->assertEquals(22, $data['bar']);
        $this->assertEquals(33, $data['baz']);
    }
}
