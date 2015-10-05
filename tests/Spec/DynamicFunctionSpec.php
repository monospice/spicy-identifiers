<?php

namespace Spec\Monospice\SpicyIdentifiers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Monospice\SpicyIdentifiers\Tools\CaseFormat;
use Monospice\SpicyIdentifiers\DynamicFunction;

class DynamicFunctionSpec extends ObjectBehavior
{
    /**
     * An identifier parts array for testing
     *
     * @var array
     */
    protected $identifierParts;

    function let()
    {
        $this->identifierParts = ['name'];
        $this->beConstructedWith($this->identifierParts);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Monospice\SpicyIdentifiers\DynamicFunction');
        $this->shouldHaveType('Monospice\SpicyIdentifiers\DynamicIdentifier');
    }

    function it_determines_if_the_function_exists()
    {
        $this->beConstructedThrough('parseFromUnderscore', ['strlen']);
        $this->exists()->shouldReturn(true);
    }

    function it_determines_if_the_function_does_not_exist()
    {
        $this->beConstructedThrough('parseFromUnderscore', ['not_function']);
        $this->exists()->shouldReturn(false);
    }

    function it_calls_the_function_represented_by_the_parser()
    {
        $this->beConstructedThrough('parseFromUnderscore', ['strlen']);
        $this->call(['test'])->shouldReturn(4);
    }
}
