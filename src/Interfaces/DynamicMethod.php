<?php

namespace Monospice\SpicyIdentifiers\Interfaces;

/**
 * Parses and manipulates method names. Useful when working with dynamic method
 * names
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
     *
     * @param mixed $context The context to check in
     *
     * return bool True if the method exists in the given context
     */
    public function existsIn($context);

    /**
     * An alias for existsIn()
     *
     * @api
     *
     * @param mixed $context The context to check in
     *
     * return bool True if the method exists in the given context
     */
    public function exists($context);

    /**
     * Call the method represented by the the current DynamicMethod instance
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
    public function callIn($context, array $arguments);

    /**
     * An alias for callIn()
     *
     * @api
     * @see call_user_func_array()
     * @link http://php.net/manual/en/function.call-user-func-array.php
     *
     * @param array $arguments The array of arguments to pass to the called
     * method
     * @param mixed $context The context in which to call the method
     *
     * @return mixed The return value of the called method
     */
    public function call($context, array $arguments);
}
