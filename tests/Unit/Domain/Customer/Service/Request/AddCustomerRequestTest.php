<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Customer\Service\Request;

use Sakila\Command\CommandInterface;
use Sakila\Domain\Customer\Service\Request\AddCustomerRequest;
use Sakila\Test\AbstractUnitTestCase;

class AddCustomerRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $cut        = new AddCustomerRequest($attributes);

        $this->assertInstanceOf(CommandInterface::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
