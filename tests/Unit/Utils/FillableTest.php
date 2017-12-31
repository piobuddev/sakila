<?php declare(strict_types=1);

namespace Sakila\Test\Utils;

use Sakila\Test\AbstractUnitTestCase;
use Sakila\Utils\Fillable;

class FillableTest extends AbstractUnitTestCase
{
    public function testPopulatesObjectWithCamelCaseDataUsingProperties()
    {
        $data = ['fooBar' => 1, 'barBaz' => 2, 'bazQux' => 3];
        $cut  = new class
        {
            use Fillable;

            public $fooBar;
            public $barBaz;
            public $bazQux;
        };

        $cut->fill($data);

        $this->assertEquals($data['fooBar'], $cut->fooBar);
        $this->assertEquals($data['barBaz'], $cut->barBaz);
        $this->assertEquals($data['bazQux'], $cut->bazQux);
    }

    public function testPopulatesObjectWithMixedValuesUsingProperties()
    {
        $data = ['foo_bar' => 1, 'barBaz' => 2, 'baz_qux' => 3];
        $cut  = new class
        {
            use Fillable;

            public $fooBar;
            public $barBaz;
            public $bazQux;
        };

        $cut->fill($data);

        $this->assertEquals($data['foo_bar'], $cut->fooBar);
        $this->assertEquals($data['barBaz'], $cut->barBaz);
        $this->assertEquals($data['baz_qux'], $cut->bazQux);
    }

    public function testPopulatesObjectWithMixedValuesUsingMethodsAndProperties()
    {
        $data = ['foo_bar' => 1, 'barBaz' => 2, 'baz_qux' => 3];
        $cut  = new class
        {
            use Fillable;

            public $fooBar;
            public $barBaz;
            public $bazQux;

            public function setFooBar($fooBar)
            {
                $this->fooBar = $fooBar;
            }

            public function setBarBaz($barBaz)
            {
                $this->barBaz = $barBaz;
            }
        };

        $cut->fill($data);

        $this->assertEquals($data['foo_bar'], $cut->fooBar);
        $this->assertEquals($data['barBaz'], $cut->barBaz);
        $this->assertEquals($data['baz_qux'], $cut->bazQux);
    }
}
