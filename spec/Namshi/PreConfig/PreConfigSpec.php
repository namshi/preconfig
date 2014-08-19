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

    function it_should_get_by_key_for_first_level_without_fallback_for_non_existing_value()
    {
        $argument = ['key1' => 'value1', 'key2' => 'value2'];
        $this->beConstructedWith($argument);
        $this->shouldHaveType('Namshi\PreConfig\PreConfig');
        $this->get('key25')->shouldEqual(null);
    }


}
