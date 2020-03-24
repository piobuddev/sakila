<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Film\Service\Request;

use Sakila\Command\CommandInterface;
use Sakila\Domain\Film\Service\Request\UpdateFilmRequest;
use Sakila\Test\AbstractUnitTestCase;

class UpdateFilmRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['foo' => 'bar'];
        $filmId     = 1;
        $cut        = new UpdateFilmRequest($filmId, $attributes);

        $this->assertInstanceOf(CommandInterface::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($filmId, $cut->getFilmId());
    }
}
