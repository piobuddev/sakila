<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Actor\Requests;

use Sakila\Command\Command;
use Sakila\Domain\Country\Service\Request\UpdateCountryRequest;
use Sakila\Test\AbstractUnitTestCase;

class UpdateCountryRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['country' => 'Germany'];
        $countryId  = 1;
        $cut        = new UpdateCountryRequest($countryId, $attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($countryId, $cut->getCountryId());
    }
}
