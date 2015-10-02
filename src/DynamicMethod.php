<?php

namespace Monospice\SpicyIdentifiers;

use Monospice\SpicyIdentifiers\DynamicIdentifier;
use Monospice\SpicyIdentifiers\Tools\CaseFormat;

/**
 * Parses and manipulates method names. Useful when working with dynamic method
 * names
 *
 * @author Cy Rossignol <cy.rossignol@yahoo.com>
 */
class DynamicMethod extends DynamicIdentifier implements Interfaces\DynamicMethod
{
    /**
     * The string constant representing the default case to use for this
     * identifier type if no output case format has been explicitly set
     *
     * @internal
     * @var string
     */
    protected static $defaultCase = CaseFormat::CAMEL_CASE;

    // Inherit Doc from Interfaces\DynamicMethod
    public function existsIn($context = null)
    {
        return method_exists($context, $this->name());
    }

    // Inherit Doc from Interfaces\DynamicMethod
    public function exists($context = null)
    {
        return $this->existsIn($context);
    }

    // Inherit Doc from Interfaces\DynamicMethod
    public function callIn($context, array $arguments)
    {
        $methodName = $this->name();

        return call_user_func_array([$context, $methodName], $arguments);
    }

    // Inherit Doc from Interfaces\DynamicMethod
    public function call($context, array $arguments)
    {
        return $this->callIn($context, $arguments);
    }
}
