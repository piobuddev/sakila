<?php

namespace Sakila\Test\Entity;

use Sakila\Domain\Actor\Entity\ActorEntity;
use Sakila\Entity\Builder;
use Sakila\Entity\Factory;
use Sakila\Exceptions\InvalidArgumentException;
use Sakila\Test\AbstractIntegrationTestCase;

class FactoryTest extends AbstractIntegrationTestCase
{
    /**
     * @var \Sakila\Entity\Factory
     */
    private $cut;

    protected function setUp()
    {
        parent::setUp();

        $this->cut = new Factory(new Builder());
    }

    public function testCreateEntity()
    {
        /** @var \Sakila\Domain\Actor\Entity\ActorEntity $actor */
        $actor = $this->cut->create('actor', ['first_name' => 'Mia']);
        $this->assertInstanceOf(ActorEntity::class, $actor);

        $this->assertEquals('Mia', $actor->firstName);
    }

    public function testThrowExceptionWhenEntityDoesNotExist()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid resource name `some_resource`');

        $this->cut->create('some_resource');
    }
}