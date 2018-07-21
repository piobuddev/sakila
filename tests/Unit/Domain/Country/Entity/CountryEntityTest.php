<?php declare(strict_types=1);

namespace Sakila\Test\Domain\Actor\Entity;

use Sakila\Domain\Country\Entity\CountryEntity;
use Sakila\Entity\AbstractEntity;
use Sakila\Test\AbstractUnitTestCase;

class CountryEntityTest extends AbstractUnitTestCase
{
    /**
     * @var \Sakila\Domain\Country\Entity\CountryEntity
     */
    private $cut;

    protected function setUp()
    {
        parent::setUp();

        $this->cut = new CountryEntity();
    }

    public function testInstanceOfAbstractEntity()
    {
        $this->assertInstanceOf(AbstractEntity::class, $this->cut);
    }
}
