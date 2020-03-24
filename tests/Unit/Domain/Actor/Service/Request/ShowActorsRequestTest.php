<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Actor\Service\Request;

use Sakila\Command\CommandInterface;
use Sakila\Domain\Actor\Service\Request\ShowActorsRequest;
use Sakila\Test\AbstractUnitTestCase;

class ShowActorsRequestTest extends AbstractUnitTestCase
{
    public function testReturnsExpectedData()
    {
        $page = 2;
        $size = 5;
        $cut = new ShowActorsRequest($page, $size);

        $this->assertInstanceOf(CommandInterface::class, $cut);
        $this->assertEquals($page, $cut->getPage());
        $this->assertEquals($size, $cut->getPageSize());
    }
}
