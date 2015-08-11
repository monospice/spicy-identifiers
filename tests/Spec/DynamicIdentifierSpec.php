<?php

namespace Spec\Monospice\SpicyIdentifiers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Monospice\SpicyIdentifiers\DynamicIdentifier;
use Monospice\SpicyIdentifiers\Tools\CaseFormat;

class DynamicIdentifierSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(['identifier', 'name', 'parts', 'array'],
            CaseFormat::CAMEL_CASE);
        $this->shouldHaveType('Monospice\SpicyIdentifiers' .
            '\DynamicIdentifier');
    }

    function it_returns_the_array_of_parsed_identifier_name_parts()
    {
        $this->beConstructedWith(['identifier', 'name', 'parts', 'array'],
            CaseFormat::CAMEL_CASE);
        $this->getParts()->shouldReturn(['identifier', 'name', 'parts', 'array']);
    }

    function it_returns_the_value_of_a_single_identifier_name_part()
    {
        $this->beConstructedWith(['identifier', 'name', 'parts', 'array'],
            CaseFormat::CAMEL_CASE);
        $this->getPart(0)->shouldReturn('identifier');
    }

    function it_returns_all_of_the_identifier_part_keys()
    {
        $this->beConstructedWith(['identifier', 'name', 'parts', 'array'],
            CaseFormat::CAMEL_CASE);
        $this->getPartKeys()->shouldReturn([0, 1, 2, 3]);
    }

    function it_returns_the_keys_corresponding_to_a_given_identifier_part()
    {
        $this->beConstructedWith(['identifier', 'name', 'parts', 'array'],
            CaseFormat::CAMEL_CASE);
        $this->getPartKeys('name')->shouldReturn([1]);
        $this->getPartKeys('not a identifier part')->shouldReturn([]);
    }

    function it_returns_the_number_of_identifier_name_parts()
    {
        $this->beConstructedWith(['identifier', 'name', 'parts', 'array'],
            CaseFormat::CAMEL_CASE);
        $this->getNumParts()->shouldReturn(4);
    }

    function it_determines_if_the_given_identifier_part_exists()
    {
        $this->beConstructedWith(['identifier', 'name', 'parts', 'array'],
            CaseFormat::CAMEL_CASE);
        $this->hasPart(0)->shouldReturn(true);
        $this->hasPart(999)->shouldReturn(false);
    }

    function it_parses_a_identifier_name_into_an_array_from_camel_case()
    {
        $this->beConstructedThrough('parseFromCamelCase', ['aIdentifierName']);
        $this->getParts()->shouldReturn(['a', 'Identifier', 'Name']);
    }

    function it_parses_a_identifier_name_into_an_array_from_underscores()
    {
        $this->beConstructedThrough('parseFromUnderscore', ['a_identifier_name']);
        $this->getParts()->shouldReturn(['a', 'identifier', 'name']);
    }

    function it_parses_a_identifier_name_into_an_array_from_hyphenated_case()
    {
        $this->beConstructedThrough('parseFromHyphen', ['an-identifier-name']);
        $this->getParts()->shouldReturn(['an', 'identifier', 'name']);
    }

    function it_sets_the_default_output_case_from_the_parsed_identifier_name()
    {
        $this->beConstructedThrough('parseFromCamelCase', ['aIdentifierName']);
        $this->getOutputCase()->shouldReturn(CaseFormat::CAMEL_CASE);
    }

    function it_accepts_a_constant_for_the_output_case_format()
    {
        $this->beConstructedThrough('parseFromCamelCase', ['aIdentifierName']);
        $this->setOutputCase(CaseFormat::UNDERSCORE);
        $this->getOutputCase()->shouldReturn(CaseFormat::UNDERSCORE);
    }

    function it_builds_a_identifier_name_into_camel_case()
    {
        $this->beConstructedThrough('parseFromUnderscore', ['a_identifier_name']);
        $this->buildCamelCase()->shouldReturn('aIdentifierName');
    }

    function it_builds_a_identifier_name_into_underscore_case()
    {
        $this->beConstructedThrough('parseFromCamelCase', ['aIdentifierName']);
        $this->buildUnderscore()->shouldReturn('a_identifier_name');
    }

    function it_merges_a_range_of_parts_with_an_explicit_end()
    {
        $this->beConstructedThrough('parseFromCamelCase', ['aIdentifierName']);
        $this->mergePartsRange(1, 2);
        $this->getParts()->shouldReturn(['a', 'IdentifierName']);
    }

    function it_merges_a_range_of_parts_with_the_remaining_parts()
    {
        $this->beConstructedThrough('parseFromCamelCase', ['aIdentifierName']);
        $this->mergePartsRange(1);
        $this->getParts()->shouldReturn(['a', 'IdentifierName']);
        $this->mergePartsRange(999);
        $this->getParts()->shouldReturn(['a', 'IdentifierName']);
    }

    function it_checks_and_merges_a_range_of_parts_with_an_explicit_end()
    {
        $this->beConstructedThrough('parseFromCamelCase', ['aIdentifierName']);
        $this->mergePartsRangeIf([1 => 'Identifier', 2 => 'Name']);
        $this->getParts()->shouldReturn(['a', 'IdentifierName']);
        $this->mergePartsRangeIf([0 => 'invalidTest', 1 => 'IdentifierName']);
        $this->getParts()->shouldReturn(['a', 'IdentifierName']);
    }

    function it_checks_and_merges_a_range_of_parts_with_the_remaining_parts()
    {
        $this->beConstructedThrough('parseFromCamelCase', ['aIdentifierName']);
        $this->mergePartsRangeIf([1 => 'Identifier']);
        $this->getParts()->shouldReturn(['a', 'IdentifierName']);
        $this->mergePartsRangeIf([0 => 'invalidTest']);
        $this->getParts()->shouldReturn(['a', 'IdentifierName']);
    }

    function it_renames_a_identifier_part()
    {
        $this->beConstructedThrough('parseFromCamelCase', ['aIdentifierName']);
        $this->renamePart(0, 'changed');
        $this->getParts()->shouldReturn(['changed', 'Identifier', 'Name']);
    }

    function it_returns_the_current_instance_for_chaining()
    {
        $this->beConstructedWith(['identifier', 'name', 'parts', 'array'],
            CaseFormat::CAMEL_CASE);
        $this->parseFromCamelCase('anIdentifierName')
            ->shouldHaveType('Monospice\SpicyIdentifiers\DynamicIdentifier');
        $this->parseFromUnderscore('an_identifier_name')
            ->shouldHaveType('Monospice\SpicyIdentifiers\DynamicIdentifier');
        $this->mergePartsRange(0, 1)
            ->shouldHaveType('Monospice\SpicyIdentifiers\DynamicIdentifier');
        $this->mergePartsRangeIf([0 => 'invalid'])
            ->shouldHaveType('Monospice\SpicyIdentifiers\DynamicIdentifier');
        $this->renamePart(0, 'changed')
            ->shouldHaveType('Monospice\SpicyIdentifiers\DynamicIdentifier');
    }

    function it_throws_an_exception_when_trying_to_set_an_invalid_output_case()
    {
        $this->beConstructedThrough('parseFromCamelCase', ['aIdentifierName']);
        $this->shouldThrow('\InvalidArgumentException')
            ->during('setOutputCase', ['not a valid output case']);
    }

}
