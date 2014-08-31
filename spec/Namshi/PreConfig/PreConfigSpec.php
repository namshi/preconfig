<?php

namespace spec\Namshi\PreConfig;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PreConfigSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Namshi\PreConfig\PreConfig');
    }

    function it_is_initializable_without_arguments()
    {
        $this->beConstructedWith();
        $this->shouldHaveType('Namshi\PreConfig\PreConfig');
    }

    function it_is_initializable_with_arguments()
    {
        $this->beConstructedWith([]);
        $this->shouldHaveType('Namshi\PreConfig\PreConfig');
    }

    function it_should_return_empty_array_if_initialized_without_arguments()
    {
        $this->beConstructedWith();
        $this->shouldHaveType('Namshi\PreConfig\PreConfig');
        $this->get()->shouldEqual([]);
    }

    function it_should_return_values_array_if_initialized_with_array()
    {
        $argument = ['key1' => 'value1', 'key2' => 'value2'];
        $this->beConstructedWith($argument);
        $this->shouldHaveType('Namshi\PreConfig\PreConfig');
        $this->get()->shouldEqual($argument);
    }

    function it_should_get_by_key_for_first_level()
    {
        $argument = ['key1' => 'value1', 'key2' => 'value2'];
        $this->beConstructedWith($argument);
        $this->shouldHaveType('Namshi\PreConfig\PreConfig');
        $this->get('key1')->shouldEqual('value1');
    }

    function it_should_get_by_non_existing_key_for_first_level_with_fallback()
    {
        $argument = ['key1' => 'value1', 'key2' => 'value2'];
        $this->beConstructedWith($argument);
        $this->shouldHaveType('Namshi\PreConfig\PreConfig');
        $this->get('nonExisting', [], 'fallback')->shouldEqual('fallback');
    }

    function it_should_get_by_existing_key_for_first_level_with_fallback()
    {
        $argument = ['key1' => 'value1', 'key2' => 'value2'];
        $this->beConstructedWith($argument);
        $this->shouldHaveType('Namshi\PreConfig\PreConfig');
        $this->get('key1', [], 'fallback')->shouldEqual('value1');
    }

    function it_should_get_by_key_for_first_level_without_fallback_for_non_existing_value()
    {
        $argument = ['key1' => 'value1', 'key2' => 'value2'];
        $this->beConstructedWith($argument);
        $this->shouldHaveType('Namshi\PreConfig\PreConfig');
        $this->get('key25')->shouldEqual(null);
    }

    function it_should_get_by_key_for_multi_level_without_fallback_for_non_existing_value()
    {
        $argument = ['key1' => ['key2' => 'value2']];
        $this->beConstructedWith($argument);
        $this->shouldHaveType('Namshi\PreConfig\PreConfig');

        $this->get('key1.key2')->shouldEqual('value2');
    }

    function it_should_get_by_key_for_one_level_preferences()
    {
        $argument = [
            'key1' => [
                'key2' => '{{key1.key3}}',
                'key3' => 'yes'
            ]
        ];
        $this->beConstructedWith($argument);
        $this->shouldHaveType('Namshi\PreConfig\PreConfig');

        $this->get('key1.key2')->shouldEqual('yes');
    }

    function it_should_get_by_key_for_multi_level_preferences()
    {
        $argument = [
            'key1' => [
                'key2' => '{{ key1.key3 }}',
                'key3' => [
                    'key4' => 'value4',
                    'key5' => 'value5'
                ]
            ]
        ];
        $this->beConstructedWith($argument);
        $this->shouldHaveType('Namshi\PreConfig\PreConfig');

        $this->get('key1.key2')->shouldEqual([
            'key4' => 'value4',
            'key5' => 'value5'
        ]);
    }

    function it_should_get_by_key_for_first_level_with_params()
    {
        $argument = ['key1' => 'Hello :name', 'key2' => 'value2'];
        $this->beConstructedWith($argument);
        $this->shouldHaveType('Namshi\PreConfig\PreConfig');
        $this->get('key1', ['name' => 'Ayham'])->shouldEqual('Hello Ayham');
    }

    function it_should_get_by_key_for_first_level_containing_params_without_passing_params()
    {
        $argument = ['key1' => 'Hello :name', 'key2' => 'value2'];
        $this->beConstructedWith($argument);
        $this->shouldHaveType('Namshi\PreConfig\PreConfig');
        $this->get('key1')->shouldEqual('Hello :name');
    }

    function it_should_get_by_key_for_multi_levels_with_params()
    {
        $argument = ['key1' => ['key2' => 'Hello :name']];
        $this->beConstructedWith($argument);
        $this->shouldHaveType('Namshi\PreConfig\PreConfig');
        $this->get('key1.key2', ['name' => 'Ayham'])->shouldEqual('Hello Ayham');
    }

    function it_should_get_by_key_for_multi_levels_with_multiple_params()
    {
        $argument = ['key1' => ['key2' => 'Hello :name, good :time']];
        $this->beConstructedWith($argument);
        $this->shouldHaveType('Namshi\PreConfig\PreConfig');
        $this->get('key1.key2', ['name' => 'Ayham', 'time' => 'morning'])->shouldEqual('Hello Ayham, good morning');
    }

    function it_should_get_by_key_for_multi_levels_with_multi_params_in_different_levels_shouldnt_be_parsed()
    {
        $argument = ['key1' => ['key2' => 'Hello :name, good :time']];
        $this->beConstructedWith($argument);
        $this->shouldHaveType('Namshi\PreConfig\PreConfig');
        $this->get('key1', ['name' => 'Ayham', 'time' => 'morning'])->shouldEqual($argument['key1']);
    }

    function it_should_throw_exception_in_case_of_circular_reference()
    {
        $argument = [
            'key1' => [
                'key2' => '{{ key1.key3 }}',
                'key3' => '{{ key1.key2 }}'
            ]
        ];
        $this->beConstructedWith($argument);
        $this->shouldHaveType('Namshi\PreConfig\PreConfig');
        $this->shouldThrow('\Namshi\PreConfig\Exception\CircularReferenceException')->duringGet('key1.key2');
    }
}
