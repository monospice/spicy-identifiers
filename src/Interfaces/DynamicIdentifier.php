<?php

namespace Monospice\SpicyIdentifiers\Interfaces;

use ArrayAccess;
use Countable;

/**
 * Parses and manipulates identifier names. Useful when working with dynamic
 * method, function, class, and variable names
 *
 * @author Cy Rossignol <cy.rossignol@yahoo.com>
 */
interface DynamicIdentifier extends ArrayAccess, Countable
{

    /**
     * Explicitly set the output case format for identifiers that build or
     * access the identifier name. If not explicitly set, the output case will
     * default to the case that the identifier name was parsed from
     *
     * @api
     *
     * @param string $outputCaseConstant The string constant representing an
     * output case format
     *
     * @return DynamicIdentifier The current DynamicIdentifier instance for
     * method chaining
     *
     * @throws \InvalidArgumentException If not provided with a valid output
     * case format
     */
    public function setOutputCase($outputCaseConstant);

    /**
     * Get the output case format that will be used for identifiers that build
     * or access the identifier name
     *
     * @api
     *
     * @return string The string constant representing an output case format
     */
    public function getOutputCase();

    /**
     * Break an identifier name into an array based on uppercase words in
     * camel case
     *
     * @api
     *
     * @param string $name The identifier name string to parse
     *
     * @return DynamicIdentifier An instance of DynamicIdentifier containing the
     * parsed identifier name data
     */
    public static function parseFromCamelCase($name);

    /**
     * Break an identifier name containing extended ASCII characters into an
     * array based on uppercase words in camel case
     *
     * @api
     *
     * @param string $name The identifier name string to parse
     *
     * @return DynamicIdentifier An instance of DynamicIdentifier containing the
     * parsed identifier name data
     */
    public static function parseFromCamelCaseExtended($name);

    /**
     * Break an identifier name into an array based on words seperated by
     * underscores
     *
     * @api
     *
     * @param string $name The identifier name string to parse
     *
     * @return DynamicIdentifier An instance of DynamicIdentifier containing the
     * parsed identifier name data
     */
    public static function parseFromUnderscore($name);

    /**
     * Break an identifier name into an array based on words seperated by
     * hyphens
     *
     * @api
     *
     * @param string $name The identifier name string to parse
     *
     * @return DynamicIdentifier An instance of DynamicIdentifier containing the
     * parsed identifier name data
     */
    public static function parseFromHyphen($name);

    /**
     * Break an identifier name into an array based on words seperated by
     * multiple case formats
     *
     * @api
     *
     * @param string $name The identifier name string to parse
     *
     * @return DynamicIdentifier An instance of DynamicIdentifier containing the
     * parsed identifier name data
     */
    public static function parseFromMixedCase($name, $arrayOfCaseFormats);

    /**
     * Return an array of the identifier parts
     *
     * @api
     *
     * @return array An array of the parts of the identifier name
     */
    public function parts();

    /**
     * Return the value of the identifier part corresponding to the given key
     *
     * @api
     *
     * @param int $key The index of the identifier part to return
     *
     * @return string The name of the corresponding identifier part
     */
    public function part($key);

    /**
     * Get the identifier part at the beginning of the identifier name
     *
     * @api
     *
     * @return string The name of the first identifier part
     */
    public function first();

    /**
     * Get the identifier part at the end of the identifier name
     *
     * @api
     *
     * @return string The name of the last identifier part
     */
    public function last();

    /**
     * Get an array of the keys of identifier parts that match the specified
     * string, or all keys if no string is provided
     *
     * @api
     *
     * @param string $partName The value of the identifier part to match
     *
     * @return array The array of matching integer keys
     */
    public function keys($partName = null);

    /**
     * Return the number of identifier parts in the parsed identifier name
     *
     * @api
     *
     * @return int The number of identifier parts
     */
    public function getNumParts();

    /**
     * Determines if the identifier name contains a part corresponding to
     * the given index
     *
     * @api
     *
     * @param int $key The index of the identifier  name part to check
     *
     * @return bool True if the identifier  name parts array contains the
     * corresponding part
     */
    public function has($key);

    /**
     * Get the string representation of the parsed identifier
     *
     * @api
     *
     * @return string The string representation of the parsed identifier
     */
    public function name();

    /**
     * Merge a range of identifier parts
     *
     * @api
     *
     * @param int $start The index of the first identifier part in the range to
     * merge
     * @param int $end The index of the last identifier part in the range
     * to merge. If no end index is given, all the remaining identifier
     * parts will be merged
     *
     * @return DynamicIdentifier The current DynamicIdentifier instance for
     * method chaining
     */
    public function mergeRange($start, $end = null);

    /**
     * Add an identifier part to the end
     *
     * @api
     *
     * @param string $part The identifier part to append
     *
     * @return DynamicIdentifier The current DynamicIdentifier instance for
     * method chaining
     */
    public function append($part);

    /**
     * An alias for append()
     *
     * @api
     *
     * @param string $newPart The identifier part to append
     *
     * @return DynamicIdentifier The current DynamicIdentifier instance for
     * method chaining
     */
    public function push($part);

    /**
     * Add an identifier part to the beginning
     *
     * @api
     *
     * @param string $part The identifier part to prepend
     *
     * @return DynamicIdentifier The current DynamicIdentifier instance for
     * method chaining
     */
    public function prepend($part);

    /**
     * Insert an identifier part at the specified position
     *
     * @api
     *
     * @param string $part The identifier part to prepend
     *
     * @return DynamicIdentifier The current DynamicIdentifier instance for
     * method chaining
     */
    public function insert($position, $part);

    /**
     * Remove the identifier part at the end
     *
     * @api
     *
     * @return DynamicIdentifier The current DynamicIdentifier instance for
     * method chaining
     */
    public function pop();

    /**
     * Remove the identifier part at the beginning
     *
     * @api
     *
     * @return DynamicIdentifier The current DynamicIdentifier instance for
     * method chaining
     */
    public function shift();

    /**
     * Remove the identifier part at the specified position
     *
     * @api
     *
     * @param int $key The index of the identifier part to remove
     *
     * @return DynamicIdentifier The current DynamicIdentifier instance for
     * method chaining
     */
    public function remove($key);

    /**
     * Replace an identifier part
     *
     * @api
     *
     * @param int $key The index of the identifier part to rename
     * @param string $renameTo The string to rename the specified identifier
     * part to
     *
     * @return DynamicIdentifier The current DynamicIdentifier instance for
     * method chaining
     *
     * @throws \OutOfBoundsException If no identifier part exists for the
     * specified index
     */
    public function replace($key, $renameTo);

    /**
     * Get the array representation of this object as an array of identifier
     * parts
     *
     * @return array The array of identifier parts
     */
    public function toArray();

    /**
     * Get the string representation of this object as an identifer name string
     *
     * @return string The identifier name
     */
    public function __toString();
}
