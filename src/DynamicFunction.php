<?php

namespace Monospice\SpicyIdentifiers;

use Monospice\SpicyIdentifiers\DynamicIdentifier;
use Monospice\SpicyIdentifiers\Tools\CaseFormat;

/**
 * Parses and manipulates function names. Useful when working with dynamic
 * functions
 *
 * @author Cy Rossignol <cy.rossignol@yahoo.com>
 */
class DynamicFunction extends DynamicIdentifier implements Interfaces\DynamicFunction
{
    /**
     * The string constant representing the default case to use for this
     * identifier type if no output case format has been explicitly set
     *
     * @internal
     * @var string
     */
    protected static $defaultCase = CaseFormat::UNDERSCORE;

    // Inherit Doc from Interfaces\DynamicFunction
    public function exists()
    {
        return function_exists($this->name());
    }

    // Inherit Doc from Interfaces\DynamicFunction
    public function call(array $arguments = [])
    {
        return call_user_func_array($this->name(), $arguments);
    }
}
