<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Customer\Service\Request;

use Sakila\Command\CommandInterface;
use Sakila\Domain\Customer\Service\Request\UpdateCustomerRequest;
use Sakila\Test\AbstractUnitTestCase;

class UpdateCustomerRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $customerId = 1;
        $cut        = new UpdateCustomerRequest($customerId, $attributes);

        $this->assertInstanceOf(CommandInterface::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($customerId, $cut->getCustomerId());
    }
}
