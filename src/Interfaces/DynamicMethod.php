<?php

namespace Monospice\SpicyIdentifiers\Interfaces;

/**
 * Parses and manipulates method names. Useful when working with dynamic
 * methods
 *
 * @author Cy Rossignol <cy.rossignol@yahoo.com>
 */
interface DynamicMethod extends DynamicIdentifier
{
    /**
     * Check if the method represented by the curent DynamicMethod instance
     * exists in the given context
     *
     * @api
     * @see method_exists()
     * @link http://php.net/manual/en/function.method-exists.php
     *
     * @param mixed $context The context to check in
     *
     * return bool True if the method exists in the given context
     */
    public function existsOn($context);

    /**
     * Call the method represented by the the current DynamicMethod instance
     * in the specified context
     *
     * @api
     * @see call_user_func_array()
     * @link http://php.net/manual/en/function.call-user-func-array.php
     *
     * @param mixed $context The context in which to call the method
     * @param array $arguments The array of arguments to pass to the called
     * method
     *
     * @return mixed The return value of the called method
     */
    public function callOn($context, array $arguments = []);

    /**
     * Invoke the method represented by the current DynamicMethod instance
     * in the specified context. Useful for specific cases when a protected or
     * private method must be called
     *
     * @api
     * @see ReflectionMethod
     * @link http://php.net/manual/en/reflectionmethod.invokeargs.php
     *
     * @param mixed $context The context in which to invoke the method
     * @param array $arguments The array of arguments to pass to the invoked
     * method
     *
     * @return mixed The return value of the invoked method
     *
     * @throws \BadMethodCallException If a statically-called method is not
     * static
     */
    public function invokeOn($context, array $arguments = []);

    /**
     * Call the static method represented by the current DynamicMethod
     * instance in the specified context
     *
     * @api
     * @see forward_static_call_array()
     * @link http://php.net/manual/en/function.forward-static-call-array.php
     *
     * @param mixed $context The context in which to call the static method
     * @param array $arguments The array of arguments to pass to the called
     * method
     *
     * @return mixed The return value of the called method
     */
    public function forwardStaticCallTo($context, array $arguments = []);

    /**
     * Throw a BadMethodCallException. The default exception message assumes
     * that the exception is thrown because the method doesn't exist
     *
     * @api
     *
     * @param string|null $message The customizable exception message
     *
     * @return void
     *
     * @throws \BadMethodCallException With the given message or a default
     * message that assumes that the method doesn't exist
     */
    public function throwException($message = null);

    /**
     * Throw a BadMethodCallException if the method represented by this
     * instance does not exist
     *
     * @api
     *
     * @param mixed       $context The context to check in for method existance
     * @param string|null $message The customizable exception message
     *
     * @return $this
     *
     * @throws \BadMethodCallException If the method represented by this
     * instance does not exist
     */
    public function throwExceptionIfMissingOn($context, $message = null);
}
