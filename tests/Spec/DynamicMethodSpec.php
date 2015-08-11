<?php

namespace Spec\Monospice\SpicyIdentifiers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Monospice\SpicyIdentifiers\Tools\CaseFormat;
use Monospice\SpicyIdentifiers\DynamicMethod;

class DynamicMethodSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(['method', 'name', 'parts', 'array'],
            CaseFormat::CAMEL_CASE);
        $this->shouldHaveType('Monospice\SpicyIdentifiers\DynamicMethod');
    }

    function it_determines_if_the_method_exists_in_the_given_context()
    {
        $this->beConstructedThrough('parseFromCamelCase', ['getName']);
        $this->exists($this)->shouldReturn(true);
        $this->exists(new \stdClass())->shouldReturn(false);
    }

    function it_calls_the_method_represented_by_the_parser()
    {
        $this->beConstructedThrough('parseFromCamelCase', ['getName']);
        $this->call($this, [])->shouldReturn('getName');
    }

}
