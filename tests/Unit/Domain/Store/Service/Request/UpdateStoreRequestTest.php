<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Store\Service\Request;

use Sakila\Command\Command;
use Sakila\Domain\Store\Service\Request\UpdateStoreRequest;
use Sakila\Test\AbstractUnitTestCase;

class UpdateStoreRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $storeId    = 1;
        $cut        = new UpdateStoreRequest($storeId, $attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($storeId, $cut->getStoreId());
    }
}
