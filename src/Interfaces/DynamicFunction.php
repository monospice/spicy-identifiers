<?php

namespace Monospice\SpicyIdentifiers\Interfaces;

/**
 * Parses and manipulates function names. Useful when working with dynamic
 * functions
 *
 * @author Cy Rossignol <cy.rossignol@yahoo.com>
 */
interface DynamicFunction extends DynamicIdentifier
{
    /**
     * Check if the function represented by the curent DynamicFunction instance
     * exists
     *
     * @api
     * @see function_exists()
     * @link http://php.net/manual/en/function.function-exists.php
     *
     * @param mixed $context The context to check in
     *
     * return bool True if the function exists in the given context
     */
    public function exists();

    /**
     * Call the function represented by the current DynamicFunction instance
     *
     * @api
     * @see call_user_func_array()
     * @link http://php.net/manual/en/function.call-user-func-array.php
     *
     * @param array $arguments The array of arguments to pass to the called
     * function
     *
     * @return mixed The return value of the called function
     */
    public function call(array $arguments = []);

    /**
     * Throw a BadFunctionCallException. The default exception message assumes
     * that the exception is thrown because the function doesn't exist
     *
     * @api
     *
     * @param string|null $message The customizable exception message
     *
     * @return void
     *
     * @throws \BadFunctionCallException With the given message or a default
     * message that assumes that the function doesn't exist
     */
    public function throwException($message = null);

    /**
     * Throw a BadFunctionCallException if the function represented by this
     * instance does not exist
     *
     * @api
     *
     * @param string|null $message The customizable exception message
     *
     * @return void
     *
     * @throws \BadFunctionCallException If the function represented by this
     * instance does not exist
     */
    public function throwExceptionIfMissing($message = null);
}
