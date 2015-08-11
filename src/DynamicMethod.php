<?php

namespace Monospice\SpicyIdentifiers;

use Monospice\SpicyIdentifiers\DynamicIdentifier;

/**
 * Parses and manipulates method names. Useful when working with dynamic method
 * names
 *
 * @author Cy Rossignol <cy.rossignol@yahoo.com>
 */
class DynamicMethod extends DynamicIdentifier implements Interfaces\DynamicMethod
{

    // Inherit Doc from Interfaces\DynamicMethod
    public function exists($context)
    {
        return method_exists($context, $this->getName());
    }


    // Inherit Doc from Interfaces\DynamicMethod
    public function call($context, array $arguments)
    {
        $methodName = $this->getName();

        return call_user_func_array([$context, $methodName], $arguments);
    }

}
