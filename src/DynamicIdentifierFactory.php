<?php

namespace Monospice\SpicyIdentifiers;

use Monospice\SpicyIdentifiers\DynamicIdentifier;
use Monospice\SpicyIdentifiers\Tools\CaseFormat;
use Monospice\SpicyIdentifiers\Tools\Parser;

/**
 * A factory trait to help instantiate a new DynamicIdentifier instance
 *
 * @author Cy Rossignol <cy.rossignol@yahoo.com>
 */
trait DynamicIdentifierFactory
{
    // Inherit Doc from Interfaces\DynamicIdentifier
    public static function load($identifierName)
    {
        $parserClass = get_called_class();

        return new $parserClass([$identifierName]);
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public static function parse($identifierName)
    {
        $parserClass = get_called_class();
        $caseFormat = $parserClass::$defaultCase;

        return new $parserClass(Parser::parse($identifierName, $caseFormat));
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public static function parseFromCamelCase($identifierName)
    {
        $parserClass = get_called_class();

        return new $parserClass(Parser::parseFromCamelCase($identifierName));
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public static function parseFromCamelCaseExtended($identifierName)
    {
        $parserClass = get_called_class();

        return new $parserClass(
            Parser::parseFromCamelCaseExtended($identifierName)
        );
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public static function parseFromUnderscore($identifierName)
    {
        $parserClass = get_called_class();

        return new $parserClass(Parser::parseFromUnderscore($identifierName));
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public static function parseFromHyphen($identifierName)
    {
        $parserClass = get_called_class();

        return new $parserClass(Parser::parseFromHyphen($identifierName));
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public static function parseFromMixedCase($name, $arrayOfCaseFormats)
    {
        $parserClass = get_called_class();

        return new $parserClass(
            Parser::parseFromMixedCase($name, $arrayOfCaseFormats)
        );
    }
}
