<?php

namespace Monospice\SpicyIdentifiers;

use Monospice\SpicyIdentifiers\Tools\CaseFormat;

/**
 * Parses and manipulates identifier names. Useful when working with dynamic
 * method, function, class, and variable names
 *
 * @author Cy Rossignol <cy.rossignol@yahoo.com>
 */
class DynamicIdentifier implements Interfaces\DynamicIdentifier
{

    use DynamicIdentifierFactory;

    /**
     * array The array of identifier parts
     *
     * @internal
     */
    protected $identifierParts;

    /**
     * string The string constant representing the case to use when outputting
     * or accessing an identifier name
     *
     * @internal
     */
    protected $outputCase;

    /**
     * string The string constant representing the default case to use if no
     * output case format has been explicitly set. This defaults to the case
     * from which the identifier name was parsed
     *
     * @internal
     */
    protected $defaultCase;


    /**
     * Create a new DynamicIdentifier instance. Instead of using the constructor,
     * we recommend using one of the factory methods
     *
     * @see Factory The IdentiferParser factory methods
     *
     * @param array $parts The array of identifier parts
     * @param string $defaultCase The string constant representing the default
     * case that will be used
     */
    public function __construct(array $parts, $defaultCase)
    {
        $this->identifierParts = $parts;
        $this->defaultCase = $defaultCase;
    }


    // Inherit Doc from Interfaces\DynamicIdentifier
    public function setOutputCase($outputCaseConstant)
    {
        switch ($outputCaseConstant) {
            case CaseFormat::CAMEL_CASE: // pass-through case
            case CaseFormat::UNDERSCORE:
                $this->outputCase = $outputCaseConstant;
                return $this;
            default:
                throw new \InvalidArgumentException($outputCaseConstant .
                    ' is not a constant that represents a valid output case' .
                    ' format');
        }
    }


    // Inherit Doc from Interfaces\DynamicIdentifier
    public function getOutputCase()
    {
        if ($this->outputCase === null) {
            return $this->defaultCase;
        }

        return $this->outputCase;
    }


    // Inherit Doc from Interfaces\DynamicIdentifier
    public function getParts()
    {
        return $this->identifierParts;
    }


    // Inherit Doc from Interfaces\DynamicIdentifier
    public function getPart($key)
    {
        return $this->identifierParts[$key];
    }


    // Inherit Doc from Interfaces\DynamicIdentifier
    public function getPartKeys($partName = null)
    {
        if ($partName === null) {
            return array_keys($this->identifierParts);
        } else {
            return array_keys($this->identifierParts, $partName);
        }
    }


    // Inherit Doc from Interfaces\DynamicIdentifier
    public function getNumParts()
    {
        return count($this->identifierParts);
    }


    // Inherit Doc from Interfaces\DynamicIdentifier
    public function hasPart($key)
    {
        return array_key_exists($key, $this->identifierParts);
    }


    // Inherit Doc from Interfaces\DynamicIdentifier
    public function getName()
    {
        $buildMethod = 'build' . $this->getOutputCase();
        return $this->$buildMethod();
    }


    // Inherit Doc from Interfaces\DynamicIdentifier
    public function buildCamelCase()
    {
        return lcfirst(
            implode('', array_map('ucfirst', $this->identifierParts))
        );
    }


    // Inherit Doc from Interfaces\DynamicIdentifier
    public function buildUnderscore()
    {
        return strtolower(implode('_', $this->identifierParts));
    }


    // Inherit Doc from Interfaces\DynamicIdentifier
    public function mergePartsRange($start, $end = null)
    {
        if ($end === null) {
            $end = $this->getNumParts() - 1;
        }

        if ($end <= $start) {
            return $this;
        }

        $mergedParts = implode(
            array_slice($this->identifierParts, $start, $end)
        );
        array_splice($this->identifierParts, $start, $end, $mergedParts);

        return $this;
    }


    // Inherit Doc from Interfaces\DynamicIdentifier
    public function mergePartsRangeIf(array $mergeParts)
    {
        $numMergeParts = count($mergeParts);
        $intersection = array_intersect_assoc($this->identifierParts,
            $mergeParts);

        if (count($intersection) !== $numMergeParts) {
            return $this;
        }

        $mergeKeys = array_keys($mergeParts);

        if ($numMergeParts < 2) {
            $this->mergePartsRange($mergeKeys[0]);
        } else {
            $lastKey = $mergeKeys[count($mergeKeys) - 1];
            $this->mergePartsRange($mergeKeys[0], $lastKey);
        }

        return $this;
    }


    // Inherit Doc from Interfaces\DynamicIdentifier
    public function renamePart($part, $renameTo)
    {
        if (array_key_exists($part, $this->identifierParts)) {
            $this->identifierParts[$part] = $renameTo;
        }

        return $this;
    }

}
