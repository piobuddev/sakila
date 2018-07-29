<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Staff\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Staff\Commands\UpdateStaffCommand;
use Sakila\Test\AbstractUnitTestCase;

class UpdateStaffCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $staffId    = 1;
        $cut        = new UpdateStaffCommand($staffId, $attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($staffId, $cut->getStaffId());
    }
}
