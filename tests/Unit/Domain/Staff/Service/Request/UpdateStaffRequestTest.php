<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Staff\Service\Request;

use Sakila\Command\CommandInterface;
use Sakila\Domain\Staff\Service\Request\UpdateStaffRequest;
use Sakila\Test\AbstractUnitTestCase;

class UpdateStaffRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $staffId    = 1;
        $cut        = new UpdateStaffRequest($staffId, $attributes);

        $this->assertInstanceOf(CommandInterface::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($staffId, $cut->getStaffId());
    }
}
