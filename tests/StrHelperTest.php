<?php

namespace Awssat\StrHelper\Test;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class StrHelperTest extends TestCase
{
    /** @test */
    public function empty_str_return_an_instance_of_support_str()
    {
        $this->assertEquals('Illuminate\Support\Str', \get_class(str()));
    }

    /** @test */
    public function str_can_take_numbers()
    {
        $this->assertEquals('1', str(1));
    }

    /** @test */
    public function str_can_take_booleans()
    {
        $this->assertEquals('', str(false));
    }

    /** @test */
    public function str_can_take_objects_that_can_be_string()
    {
        $this->assertEquals('x', new class() {
            public function __toString()
            {
                return 'x';
            }
        });
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
             str('<html>hi</html>')->do(function ($string) {
                 return strip_tags($string);
             })
        );
    }

    /** @test */
    public function do_can_bring_magic_once()
    {
        $this->assertEquals(
            'hi2',
             str('<html>hi2</html>')->do(function () {
                  $this->stripTags();
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

    /** @test */
    public function do_can_bring_magic_even_better()
    {
        $this->assertEquals(
            'boo',
             str('<b>boo</b>')->stripTags()
        );
    }

    /** @test */
    public function test_if_with_built_in_functions()
    {
        $result = str('<html>hi</html>')
                    ->ifStrReplace('hi', 'welcome')
                        ->upper();

        $this->assertEquals('<HTML>WELCOME</HTML>', $result);
    }

    /** @test */
    public function test_if2_with_built_in_functions()
    {
        $result = str('<html>howdy</html>')
                    ->ifStrReplace('hi', 'welcome')
                        ->upper();

        $this->assertEquals('<html>howdy</html>', $result);
    }

    /** @test */
    public function test_if_endif_with_built_in_functions()
    {
        $result = str('<html>HOWDY</html>')
                    ->ifStrReplace('hi', 'WELCOME')
                        ->upper()
                    ->endif()
                    ->stripTags()
                    ->lower();

        $this->assertEquals('howdy', $result);
    }

    /** @test */
    public function test_if_else_endif_with_built_in_functions()
    {
        $result = [];

        foreach (['hi', 'WELCOME'] as $word) {
            $result[] = str($word)
                        ->ifContains('hi')
                            ->upper()
                            ->finish(' you')
                        ->else()
                            ->lower()
                            ->finish(' aboard')
                        ->endif()
                        ->finish(' :)');
        }

        $this->assertEquals('HI you :) welcome aboard :)', implode(' ', $result));
    }

    /** @test */
    public function test_built_in_functions()
    {
        foreach ([
                'strpos' => [
                    'wife', //str
                     ['i'], //params
                     '1',     //expectted
                    ],
                'strReplace' => [
                    'once',
                     ['c', 'z'],
                     'onze',
                ],
                'str_replace' => [
                    'twice',
                     ['c', 'x'],
                     'twixe',
                ],
                'strrchr' => [
                    'life is an illusion',
                     ['a'],
                     'an illusion',
                ],
                'explode' => [
                    'a b c d',
                     [' '],
                     new Collection(['a', 'b', 'c', 'd']),
                ],
           ] as $func => $data) {
            $this->assertEquals($data[2], str($data[0])->{$func}(...$data[1]));
        }
    }

    /** @test */
    public function str_return_collection_instead_of_array()
    {
        $this->assertEquals('Illuminate\Support\Collection', get_class(str('you|money|peach')->explode('|')));
    }

    /** @test */
    public function str_throw_exception_if_given_wrong_method()
    {
        $this->expectException(\BadMethodCallException::class);
        str('If it is complicated, then you are doing it wrong!')->callMama();
    }

    /** @test */
    public function str_do_throw_exception_if_given_no_function()
    {
        $this->expectException(\InvalidArgumentException::class);
        str('Go Duck Yourself')->do('hi');
    }

    /** @test */
    public function str_can_be_counted()
    {
        $this->assertEquals(5, count(str('Nomad')->slug()));
    }
}
