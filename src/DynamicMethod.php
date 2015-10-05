<?php

namespace Monospice\SpicyIdentifiers;

use \ReflectionClass;

use Monospice\SpicyIdentifiers\DynamicIdentifier;
use Monospice\SpicyIdentifiers\Tools\CaseFormat;

/**
 * Parses and manipulates method names. Useful when working with dynamic
 * methods
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
    public function existsOn($context)
    {
        return method_exists($context, $this->name());
    }

    // Inherit Doc from Interfaces\DynamicMethod
    public function callOn($context, array $arguments = [])
    {
        return call_user_func_array([$context, $this->name()], $arguments);
    }

    // Inherit Doc from Interfaces\DynamicMethod
    public function invokeOn($context, array $arguments = [])
    {
        if (is_string($context)) {
            return $this->invokeStaticOn($context, $arguments);
        }

        $reflectedClass = new ReflectionClass(get_class($context));

        $reflectedMethod = $reflectedClass->getMethod($this->name());
        $reflectedMethod->setAccessible(true);

        return $reflectedMethod->invokeArgs($context, $arguments);
    }

    // Inherit Doc from Interfaces\DynamicMethod
    public function forwardStaticCallTo($context, array $arguments = [])
    {
        $methodName = $this->name();

        return forward_static_call_array([$context, $methodName], $arguments);
    }

    /**
     * Invoke the static method represented by the identifier in the given
     * context
     *
     * @param string $context The context in which to invoke the method
     * @param array $arguments The array of arguments to pass to the invoked
     * method
     *
     * @return mixed The return value of the invoked method
     *
     * @throws \BadMethodCallException If the method called is not static
     */
    protected function invokeStaticOn($context, array $arguments = [])
    {
        $reflectedClass = new ReflectionClass($context);
        $reflectedMethod = $reflectedClass->getMethod($this->name());

        if ($reflectedMethod->isStatic()) {
            $reflectedMethod->setAccessible(true);

            return $reflectedMethod->invokeArgs(null, $arguments);
        }

        throw new \BadMethodCallException(
            'Attempted to call non-static method ' . $this->name() .
            ' statically'
        );
    }
}
