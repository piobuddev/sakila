<?php

namespace Sakila\Test\Entity;

use Sakila\Domain\Actor\Entity\ActorEntity;
use Sakila\Entity\AbstractEntity;
use Sakila\Entity\Builder;
use Sakila\Exceptions\InvalidArgumentException;
use Sakila\Test\AbstractIntegrationTestCase;

class BuilderTest extends AbstractIntegrationTestCase
{
    /**
     * @var \Sakila\Domain\Actor\Entity\ActorEntity
     */
    private $entity;

    /**
     * @var \Sakila\Entity\Builder
     */
    private $cut;

    protected function setUp()
    {
        parent::setUp();

        $this->entity = new ActorEntity();
        $this->cut    = new Builder();
    }

    public function testBuildEntity()
    {
        $this->assertInstanceOf(ActorEntity::class, $this->cut->build(ActorEntity::class));
    }

    public function testThrowExceptionOnInvalidEntityClass()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Class `InvalidEntityClassName` does not exist');

        $this->cut->build('InvalidEntityClassName');
    }

    public function testThrowExceptionOnNotAbstractEntity()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Entity class has to extend `%s`', AbstractEntity::class));

        $this->cut->build(Builder::class);
    }

    public function testBuildAndPopulateEntity()
    {
        $attributes = [
            'actor_id'   => 1,
            'first_name' => 'Jessica',
            'last_name'  => 'Hyde',
        ];

        /** @var \Sakila\Domain\Actor\Entity\ActorEntity $actor */
        $actor = $this->cut->build(ActorEntity::class, $attributes);

        $this->assertInstanceOf(ActorEntity::class, $actor);
        $this->assertEquals($actor->actorId, $attributes['actor_id']);
        $this->assertEquals($actor->firstName, $attributes['first_name']);
        $this->assertEquals($actor->lastName, $attributes['last_name']);
    }
}
