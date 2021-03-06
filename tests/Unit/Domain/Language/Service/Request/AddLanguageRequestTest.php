<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Language\Service\Request;

use Sakila\Command\CommandInterface;
use Sakila\Domain\Language\Service\Request\AddLanguageRequest;
use Sakila\Test\AbstractUnitTestCase;

class AddLanguageRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['name' => 'English'];
        $cut        = new AddLanguageRequest($attributes);

        $this->assertInstanceOf(CommandInterface::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
    }
}
