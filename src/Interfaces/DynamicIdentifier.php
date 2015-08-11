<?php

namespace Monospice\SpicyIdentifiers\Interfaces;

/**
 * Parses and manipulates identifier names. Useful when working with dynamic
 * method, function, class, and variable names
 *
 * @author Cy Rossignol <cy.rossignol@yahoo.com>
 */
interface DynamicIdentifier
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
     * chaining
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
     * Return an array of the identifier parts
     *
     * @api
     *
     * @return array An array of the parts of the identifier name
     */
    public function getParts();

    /**
     * Return the value of the identifier part corresponding to the given key
     *
     * @api
     *
     * @param int $key The index of the identifier part to return
     *
     * @return string The name of the corresponding identifier part
     */
    public function getPart($key);

    /**
     * Returns an array of integer keys corresponding to the given identifier
     * part name value
     *
     * @api
     *
     * @param string $partName The value of the identifier part to match
     *
     * @return array The array of matching integer keys
     */
    public function getPartKeys($partName = null);

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
    public function hasPart($key);

    /**
     * Get the string representation of the parsed identifier
     *
     * @api
     *
     * @return string The string representation of the parsed identifier
     */
    public function getName();

    /**
     * Get the camelCase representation of the parsed identifier
     *
     * @api
     *
     * @return string The camelCase representation of the parsed identifier
     */
    public function buildCamelCase();

    /**
     * Get the underscore (snake_case) representation of the parsed identifier
     *
     * @api
     *
     * @return string The underscore (snake_case) representation of the parsed
     * identifier
     */
    public function buildUnderscore();

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
     * chaining
     */
    public function mergePartsRange($start, $end = null);

    /**
     * Merge a range of identifier parts if their key/value pairs match
     * the key/value pairs in the argument array
     *
     * @api
     *
     * @param array $mergeParts The array containing a range of identifier parts
     * to merge where the key represents the index of the identifier part and
     * the value is the expected name of that identifier part
     *
     * @return DynamicIdentifier The current DynamicIdentifier instance for
     * chaining
     */
    public function mergePartsRangeIf(array $mergeParts);

    /**
     * Rename an identifier part
     *
     * @api
     *
     * @param integer $key The index of the identifier part to rename
     * @param string $renameTo The string to rename the specified identifier
     * part to
     *
     * @return DynamicIdentifier The current DynamicIdentifier instance for
     * chaining
     */
    public function renamePart($key, $renameTo);

}
