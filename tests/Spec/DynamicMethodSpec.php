<?php

namespace Spec\Monospice\SpicyIdentifiers;

use BadMethodCallException;
use Monospice\SpicyIdentifiers\DynamicMethod;
use Monospice\SpicyIdentifiers\DynamicIdentifier;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DynamicMethodSpec extends ObjectBehavior
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
        $this->shouldHaveType(DynamicMethod::class);
        $this->shouldHaveType(DynamicIdentifier::class);
    }

    function it_determines_if_the_method_exists()
    {
        $this->existsOn($this)->shouldReturn(true);
    }

    function it_calls_the_method()
    {
        $this->callOn($this)->shouldReturn('name');
    }

    function it_calls_the_static_method()
    {
        $this->beConstructedThrough('parseFromCamelCase', [ 'staticTest' ]);

        $this->callOn(StaticTestStub::class, [ 'TestArg' ])
            ->shouldReturn('staticTestArg');
    }

    function it_calls_the_method_from_a_scope()
    {
        $this->beConstructedThrough('parseFromCamelCase', [ 'privateTest' ]);

        $this->callFromScopeOn(new PrivateTestStub(), [ 'TestArg' ])
            ->shouldReturn('privateTestArg');
    }

    function it_calls_the_static_method_from_a_scope()
    {
        $this->beConstructedThrough('parseFromCamelCase', [ 'privateTest' ]);

        $this->callFromScopeOn(PrivateTestStub::class, [ 'TestArg' ])
            ->shouldReturn('privateTestArg');
    }

    function it_forwards_the_static_call_to_a_method()
    {
        $this->beConstructedThrough('parseFromCamelCase', [ 'staticTest' ]);

        $this->forwardStaticCallTo(StaticTestStub::class, [ 'TestArg' ])
            ->shouldReturn('staticTestArg');
    }

    function it_throws_an_exception_when_instructed_to_throw_an_exception()
    {
        $this->shouldThrow(BadMethodCallException::class)
            ->during('throwException');
    }

    function it_throws_an_exception_if_the_method_does_not_exist()
    {
        $this->beConstructedThrough('parseFromCamelCase', [ 'notAMethod' ]);

        $this->shouldThrow(BadMethodCallException::class)
            ->during('throwExceptionIfMissingOn', [ $this ]);
    }
}

class StaticTestStub
{
    public static function staticTest($testArg)
    {
        return 'static' . $testArg;
    }
}

class PrivateTestStub
{
    private static function privateTest($testArg)
    {
        return 'private' . $testArg;
    }
}
