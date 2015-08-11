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
    public static function parseFromCamelCase($identifierName)
    {
        $parserClass = get_called_class();
        return new $parserClass(
            Parser::parseFromCamelCase($identifierName),
            CaseFormat::CAMEL_CASE
        );
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public static function parseFromUnderscore($identifierName)
    {
        $parserClass = get_called_class();
        return new $parserClass(
            Parser::parseFromUnderscore($identifierName),
            CaseFormat::UNDERSCORE
        );
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public static function parseFromHyphen($identifierName)
    {
        $parserClass = get_called_class();
        return new $parserClass(
            Parser::parseFromHyphen($identifierName),
            CaseFormat::HYPHEN
        );
    }
}
