<?php

namespace Spec\Monospice\SpicyIdentifiers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Monospice\SpicyIdentifiers\Tools\CaseFormat;
use Monospice\SpicyIdentifiers\DynamicMethod;

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
        $this->identifierParts = ['name'];
        $this->beConstructedWith($this->identifierParts);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Monospice\SpicyIdentifiers\DynamicMethod');
        $this->shouldHaveType('Monospice\SpicyIdentifiers\DynamicIdentifier');
    }

    function it_determines_if_the_method_exists_in_the_given_context()
    {
        $this->existsOn($this)->shouldReturn(true);
    }

    function it_calls_the_method_represented_by_the_parser()
    {
        $this->callOn($this)->shouldReturn('name');
    }

    function it_calls_the_static_method_represented_by_the_parser()
    {
        $this->beConstructedThrough('parseFromCamelCase', ['staticTest']);

        $this->callOn('Spec\Monospice\SpicyIdentifiers\StaticTestStub')
            ->shouldReturn('static');
    }

    function it_invokes_the_method_represented_by_the_parser()
    {
        $this->beConstructedThrough('parseFromCamelCase', ['privateTest']);
        $privateTestStub = new \Spec\Monospice\SpicyIdentifiers\PrivateTestStub;

        $this->invokeOn($privateTestStub)->shouldReturn('private');
    }

    function it_statically_invokes_the_method_represented_by_the_parser()
    {
        $this->beConstructedThrough('parseFromCamelCase', ['privateTest']);

        $this->invokeOn('Spec\Monospice\SpicyIdentifiers\PrivateTestStub')
            ->shouldReturn('private');
    }

    function it_forwards_the_static_call_to_a_method_represented_by_the_parser()
    {
        $this->beConstructedThrough('parseFromCamelCase', ['staticTest']);

        $this->forwardStaticCallTo(
            'Spec\Monospice\SpicyIdentifiers\StaticTestStub'
        )->shouldReturn('static');
    }

    function it_throws_an_exception_when_instructed_to_throw_an_exception()
    {
        $this->shouldThrow('\BadMethodCallException')
            ->during('throwException');
    }

    function it_throws_an_exception_if_the_method_does_not_exist()
    {
        $this->beConstructedThrough('parseFromCamelCase', ['notAMethod']);

        $this->shouldThrow('\BadMethodCallException')
            ->during('throwExceptionIfMissingOn', [$this]);
    }
}

class StaticTestStub
{
    public static function staticTest()
    {
        return 'static';
    }
}

class PrivateTestStub
{
    private static function privateTest()
    {
        return 'private';
    }
}
