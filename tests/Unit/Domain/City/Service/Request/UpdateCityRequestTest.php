<?php declare(strict_types=1);

namespace Sakila\Test\Domain\City\Service\Request;

use Sakila\Command\CommandInterface;
use Sakila\Domain\City\Service\Request\UpdateCityRequest;
use Sakila\Test\AbstractUnitTestCase;

class UpdateCityRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['city' => 'NY'];
        $cityId     = 1;
        $cut        = new UpdateCityRequest($cityId, $attributes);

        $this->assertInstanceOf(CommandInterface::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($cityId, $cut->getCityId());
    }
}
