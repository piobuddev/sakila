<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Actor\Requests;

use Sakila\Command\CommandInterface;
use Sakila\Domain\Country\Service\Request\AddCountryRequest;
use Sakila\Test\AbstractUnitTestCase;

class AddCountryRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['country' => 'Italy'];
        $cut        = new AddCountryRequest($attributes);

        $this->assertInstanceOf(CommandInterface::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
