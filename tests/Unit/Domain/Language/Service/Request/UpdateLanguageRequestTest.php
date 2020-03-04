<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Language\Service\Request;

use Sakila\Command\Command;
use Sakila\Domain\Language\Service\Request\UpdateLanguageRequest;
use Sakila\Test\AbstractUnitTestCase;

class UpdateLanguageRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $attributes = ['name' => 'English'];
        $languageId = 1;
        $cut        = new UpdateLanguageRequest($languageId, $attributes);

        $this->assertInstanceOf(Command::class, $cut);
        $this->assertEquals($attributes, $cut->getAttributes());
        $this->assertEquals($languageId, $cut->getLanguageId());
    }
}
