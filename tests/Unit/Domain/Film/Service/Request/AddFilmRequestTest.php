<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Film\Service\Request;

use Sakila\Command\CommandInterface;
use Sakila\Domain\Film\Service\Request\AddFilmRequest;
use Sakila\Test\AbstractUnitTestCase;

class AddFilmRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $cut        = new AddFilmRequest($attributes);

        $this->assertInstanceOf(CommandInterface::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
