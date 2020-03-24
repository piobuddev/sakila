<?php declare(strict_types=1);

namespace Sakila\Test\Domain\City\Service\Request;

use Sakila\Command\CommandInterface;
use Sakila\Domain\City\Service\Request\AddCityRequest;
use Sakila\Test\AbstractUnitTestCase;

class AddCityRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['city' => 'NY'];
        $cut        = new AddCityRequest($attributes);

        $this->assertInstanceOf(CommandInterface::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
