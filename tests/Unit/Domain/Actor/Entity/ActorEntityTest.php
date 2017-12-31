<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Actor\Entity;

use Sakila\Domain\Actor\Entity\ActorEntity;
use Sakila\Entity\AbstractEntity;
use Sakila\Test\AbstractUnitTestCase;

class ActorEntityTest extends AbstractUnitTestCase
{
    /**
     * @var \Sakila\Domain\Actor\Entity\ActorEntity
     */
    private $cut;

    protected function setUp()
    {
        parent::setUp();

        $this->cut = new ActorEntity();
    }

    public function testInstanceOfAbstractEntity()
    {
        $this->assertInstanceOf(AbstractEntity::class, $this->cut);
    }
}
