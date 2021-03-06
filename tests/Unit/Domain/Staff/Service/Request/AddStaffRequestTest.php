<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Staff\Service\Request;

use Sakila\Command\CommandInterface;
use Sakila\Domain\Staff\Service\Request\AddStaffRequest;
use Sakila\Test\AbstractUnitTestCase;

class AddStaffRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $cut        = new AddStaffRequest($attributes);

        $this->assertInstanceOf(CommandInterface::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
