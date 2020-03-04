<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Actor\Requests;

use Sakila\Command\Command;
use Sakila\Domain\Country\Service\Request\AddCountryRequest;
use Sakila\Test\AbstractUnitTestCase;

class AddCountryRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['country' => 'Italy'];
        $cut        = new AddCountryRequest($attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
