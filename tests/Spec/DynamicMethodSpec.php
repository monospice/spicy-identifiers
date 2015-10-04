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
        $this->existsIn($this)->shouldReturn(true);
        $this->exists($this)->shouldReturn(true);
        $this->exists(new \stdClass())->shouldReturn(false);
    }

    function it_calls_the_method_represented_by_the_parser()
    {
        $this->callIn($this)->shouldReturn('name');
        $this->call($this)->shouldReturn('name');
    }
}
