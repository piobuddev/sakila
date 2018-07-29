<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Staff\Commands;

use Sakila\Command\Command;
use Sakila\Domain\Staff\Commands\AddStaffCommand;
use Sakila\Test\AbstractUnitTestCase;

class AddStaffCommandTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $cut        = new AddStaffCommand($attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
