<?php

namespace Spec\Monospice\SpicyIdentifiers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Monospice\SpicyIdentifiers\DynamicIdentifier;
use Monospice\SpicyIdentifiers\Tools\CaseFormat;

class DynamicIdentifierSpec extends ObjectBehavior
{
    /**
     * An identifier parts array for testing
     *
     * @var array
     */
    protected $identifierParts;

    function let()
    {
        $this->identifierParts = ['an', 'Identifier', 'Name'];
        $this->beConstructedWith($this->identifierParts);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(
            'Monospice\SpicyIdentifiers\DynamicIdentifier'
        );
    }

    function it_is_array_accessible()
    {
        $this->shouldImplement('\ArrayAccess');
    }

    function it_is_countable()
    {
        $this->shouldImplement('\Countable');
    }

    function it_returns_the_entire_identifier_name()
    {
        $this->name()->shouldReturn('anIdentifierName');
    }

    function it_returns_the_array_of_parsed_identifier_name_parts()
    {
        $this->parts()->shouldReturn($this->identifierParts);
    }

    function it_returns_the_value_of_a_single_identifier_name_part()
    {
        $this->part(0)->shouldReturn($this->identifierParts[0]);
    }

    function it_returns_the_value_of_the_first_identifer_name_part()
    {
        $this->first()->shouldReturn($this->identifierParts[0]);
    }

    function it_returns_the_value_of_the_last_identifer_name_part()
    {
        $this->last()->shouldReturn(end($this->identifierParts));
    }

    function it_returns_all_of_the_identifier_part_keys()
    {
        $this->keys()->shouldReturn([0, 1, 2]);
    }

    function it_returns_the_keys_corresponding_to_a_given_identifier_part()
    {
        $this->keys($this->identifierParts[1])->shouldReturn([1]);
        $this->keys('not a identifier part')->shouldReturn([]);
    }

    function it_returns_the_number_of_identifier_name_parts()
    {
        $this->getNumParts()->shouldReturn(count($this->identifierParts));
    }

    function it_returns_the_number_of_identifier_name_parts_using_count()
    {
        $this->count()->shouldReturn(count($this->identifierParts));
    }

    function it_determines_if_the_given_identifier_part_exists()
    {
        $this->has(0)->shouldReturn(true);
        $this->has(999)->shouldReturn(false);
    }

    function it_determines_if_the_identifier_name_starts_with_the_given_part()
    {
        $this->startsWith('an')->shouldReturn(true);
        $this->startsWith('nope')->shouldReturn(false);
    }

    function it_determines_if_the_identifier_name_ends_with_the_given_part()
    {
        $this->endsWith('Name')->shouldReturn(true);
        $this->endsWith('nope')->shouldReturn(false);
    }

    function it_loads_an_identifier_name_without_parsing_out_parts()
    {
        $this->beConstructedThrough('load', ['anIdentifierName']);
        $this->parts()->shouldReturn(['anIdentifierName']);
    }

    function it_parses_an_identifier_name_into_an_array_from_camel_case()
    {
        $this->beConstructedThrough('parseFromCamelCase', ['anIdentifierName']);
        $this->parts()->shouldReturn(['an', 'Identifier', 'Name']);
    }

    function it_parses_an_identifier_name_into_an_array_from_extended_camel()
    {
        $this->beConstructedThrough(
            'parseFromCamelCaseExtended',
            ['änÏdentifierNáme']
        );
        $this->parts()->shouldReturn(['än', 'Ïdentifier', 'Náme']);
    }

    function it_parses_an_identifier_name_into_an_array_from_underscores()
    {
        $this->beConstructedThrough(
            'parseFromUnderscore',
            ['an_identifier_name']
        );
        $this->parts()->shouldReturn(['an', 'identifier', 'name']);
    }

    function it_parses_an_identifier_name_into_an_array_from_hyphenated_case()
    {
        $this->beConstructedThrough('parseFromHyphen', ['an-identifier-name']);
        $this->parts()->shouldReturn(['an', 'identifier', 'name']);
    }

    function it_parses_an_identifier_name_into_an_array_from_mixed_case()
    {
        $this->beConstructedThrough(
            'parseFromMixedCase',
            ['aMixed_case-identifier',[
                CaseFormat::CAMEL_CASE,
                CaseFormat::UNDERSCORE,
                CaseFormat::HYPHEN,
            ]]
        );
        $this->parts()->shouldReturn(['a', 'Mixed', 'case', 'identifier']);
    }

    function it_parses_an_identifier_name_into_an_array_from_the_default_case()
    {
        $this->beConstructedThrough('parse', ['aIdentifierName']);
        $this->parts()->shouldReturn(['a', 'Identifier', 'Name']);
    }

    function it_returns_the_current_output_case()
    {
        $this->getOutputFormat()->shouldReturn(CaseFormat::CAMEL_CASE);
    }

    function it_sets_the_default_output_case_using_the_default_case_format()
    {
        $this->beConstructedThrough('parseFromHyphen', ['an-identifier-name']);
        $this->getOutputFormat()->shouldReturn(CaseFormat::CAMEL_CASE);
    }

    function it_accepts_a_constant_for_the_output_case_format()
    {
        $this->setOutputFormat(CaseFormat::UNDERSCORE);
        $this->getOutputFormat()->shouldReturn(CaseFormat::UNDERSCORE);
    }

    function it_adds_an_identifier_part_to_the_end()
    {
        $this->append('Last');
        $this->parts()->shouldReturn(['an', 'Identifier', 'Name', 'Last']);
    }

    function it_adds_an_identifier_part_to_the_beginning()
    {
        $this->prepend('first');
        $this->parts()->shouldReturn(['first', 'an', 'Identifier', 'Name']);
    }

    function it_inserts_an_identifier_part()
    {
        $this->insert(1, 'inserted');
        $this->parts()->shouldReturn(['an', 'inserted', 'Identifier', 'Name']);
    }

    function it_removes_an_identifier_part_from_the_end()
    {
        $this->pop();
        $this->parts()->shouldReturn(['an', 'Identifier']);
    }

    function it_removes_an_identifier_part_from_the_beginning()
    {
        $this->shift();
        $this->parts()->shouldReturn(['Identifier', 'Name']);
    }

    function it_removes_an_identifier_part_from_the_specified_position()
    {
        $this->remove(1);
        $this->parts()->shouldReturn(['an', 'Name']);
    }

    function it_replaces_an_identifier_part()
    {
        $this->replace(0, 'changed');
        $this->parts()->shouldReturn(['changed', 'Identifier', 'Name']);
    }

    function it_merges_a_range_of_parts_with_an_explicit_end()
    {
        $this->mergeRange(1, 2);
        $this->parts()->shouldReturn(['an', 'IdentifierName']);
    }

    function it_merges_a_range_of_parts_with_the_remaining_parts()
    {
        $this->mergeRange(1);
        $this->parts()->shouldReturn(['an', 'IdentifierName']);
        $this->mergeRange(999);
        $this->parts()->shouldReturn(['an', 'IdentifierName']);
    }

    function it_returns_the_current_instance_for_method_chaining()
    {
        $this->parseFromCamelCase('anIdentifierName')
            ->shouldHaveType('Monospice\SpicyIdentifiers\DynamicIdentifier');
        $this->parseFromUnderscore('an_identifier_name')
            ->shouldHaveType('Monospice\SpicyIdentifiers\DynamicIdentifier');
        $this->parseFromHyphen('an_identifier_name')
            ->shouldHaveType('Monospice\SpicyIdentifiers\DynamicIdentifier');
        $this->parse('anIdentifierName')
            ->shouldHaveType('Monospice\SpicyIdentifiers\DynamicIdentifier');

        $this->append('last')
            ->shouldHaveType('Monospice\SpicyIdentifiers\DynamicIdentifier');
        $this->prepend('first')
            ->shouldHaveType('Monospice\SpicyIdentifiers\DynamicIdentifier');
        $this->insert(1, 'inserted')
            ->shouldHaveType('Monospice\SpicyIdentifiers\DynamicIdentifier');

        $this->pop()
            ->shouldHaveType('Monospice\SpicyIdentifiers\DynamicIdentifier');
        $this->shift()
            ->shouldHaveType('Monospice\SpicyIdentifiers\DynamicIdentifier');
        $this->remove(1)
            ->shouldHaveType('Monospice\SpicyIdentifiers\DynamicIdentifier');

        $this->replace(0, 'changed')
            ->shouldHaveType('Monospice\SpicyIdentifiers\DynamicIdentifier');

        $this->mergeRange(0, 1)
            ->shouldHaveType('Monospice\SpicyIdentifiers\DynamicIdentifier');
    }

    function it_provides_a_public_interface_for_array_access()
    {
        $this->offsetGet(0)->shouldReturn($this->identifierParts[0]);

        $this->offsetSet(0, 'new');
        $this->part(0)->shouldReturn('new');

        $this->offsetExists(0)->shouldReturn(true);

        $this->offsetUnset(0);
        $this->part(0)->shouldReturn('Identifier');
    }

    function it_casts_to_a_dynamic_function()
    {
        $this->toFunction()
            ->shouldHaveType('Monospice\SpicyIdentifiers\DynamicFunction');
    }

    function it_casts_to_a_dynamic_method()
    {
        $this->toMethod()
            ->shouldHaveType('Monospice\SpicyIdentifiers\DynamicMethod');
    }

    function it_casts_to_an_array()
    {
        $this->toArray()->shouldReturn($this->identifierParts);
    }

    function it_casts_to_a_string()
    {
        $this->__toString()->shouldReturn('anIdentifierName');
        $this->name()->shouldReturn((string) $this->getWrappedObject());
    }

    function it_throws_an_exception_when_replacing_a_part_that_does_not_exist()
    {
        $this->shouldThrow('\OutOfBoundsException')
            ->during('replace', [999, 'invalid']);
    }
}
