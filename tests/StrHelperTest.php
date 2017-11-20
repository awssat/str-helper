<?php

namespace Awssat\StrHelper\Test;

use PHPUnit\Framework\TestCase;

class StrHelperTest extends TestCase
{
    /** @test */
    public function empty_str_return_an_object()
    {
        $this->assertEquals('object', gettype(str()));
    }

    /** @test */
    public function empty_str_object_type_is_valid()
    {
        $this->assertEquals('Illuminate\Support\Str', get_class(str()));
    }

    /** @test */
    public function does_str_has_methods()
    {
        $this->assertTrue(
                method_exists(get_class(str()), 'slug'),
                'str()->slug() does not exist!'
            );
    }

    /** @test */
    public function str_will_cast_to_string()
    {
        $this->assertEquals('HI', str('hi')->upper());
    }

    /** @test */
    public function str_check_methods_return_boolean()
    {
        $this->assertTrue(str('hi')->upper()->is('HI'));
    }

    /** @test */
    public function str_methods_type_is_an_object()
    {
        $this->assertEquals('object', gettype(str('hi')->upper()));
    }

    /** @test */
    public function str_get_method_type_is_a_string()
    {
        $this->assertEquals('string', gettype(str('hi')->upper()->get()));
    }

    /** @test */
    public function tap_works_fine()
    {
        $this->assertEquals(
            'HI',
             str('hi')->tap(function ($value) {
                 $value = 'welcome';
             })->upper()
        );
    }

    /** @test */
    public function do_can_bring_magic()
    {
        $this->assertEquals(
            'hi',
             str('<html>hi</html>')->do(function ($value) {
                 return strip_tags($value);
             })
        );
    }

    /** @test */
    public function do_can_bring_magic_twice()
    {
        $this->assertEquals(
            'hi',
             str('<html>hi</html>')->do('strip_tags')
        );
    }
}
