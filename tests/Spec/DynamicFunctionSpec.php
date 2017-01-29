<?php

namespace Spec\Monospice\SpicyIdentifiers;

use BadFunctionCallException;
use Monospice\SpicyIdentifiers\DynamicFunction;
use Monospice\SpicyIdentifiers\DynamicIdentifier;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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
        $this->identifierParts = [ 'name' ];
        $this->beConstructedWith($this->identifierParts);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Monospice\SpicyIdentifiers\DynamicFunction');
        $this->shouldHaveType('Monospice\SpicyIdentifiers\DynamicIdentifier');
    }

    function it_determines_if_the_function_exists()
    {
        $this->beConstructedThrough('parseFromUnderscore', [ 'strlen' ]);

        $this->exists()->shouldReturn(true);
    }

    function it_determines_if_the_function_does_not_exist()
    {
        $this->beConstructedThrough('parseFromUnderscore', [ 'not_function' ]);

        $this->exists()->shouldReturn(false);
    }

    function it_calls_the_function()
    {
        $this->beConstructedThrough('parseFromUnderscore', [ 'strlen' ]);

        $this->call([ 'test' ])->shouldReturn(4);
    }

    function it_throws_an_exception_when_instructed_to_throw_an_exception()
    {
        $this->shouldThrow('BadFunctionCallException')
            ->during('throwException');
    }

    function it_throws_an_exception_if_the_function_does_not_exist()
    {
        $this->shouldThrow('BadFunctionCallException')
            ->during('throwExceptionIfMissing');
    }
}
