<?php

namespace Monospice\SpicyIdentifiers;

use Monospice\SpicyIdentifiers\Tools\CaseFormat;
use Monospice\SpicyIdentifiers\Tools\Formatter;

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
     * The string constant representing the default case to use for this
     * identifier type if no output case format has been explicitly set
     *
     * @internal
     * @var string
     */
    protected static $defaultCase = CaseFormat::CAMEL_CASE;

    /**
     * The array of identifier parts
     *
     * @internal
     * @var array
     */
    protected $identifierParts;

    /**
     * The string constant representing the case to use when outputting
     * or accessing an identifier name
     *
     * @internal
     * @var string
     */
    protected $outputCase;

    /**
     * Create a new DynamicIdentifier instance. Instead of using the constructor,
     * we recommend using one of the factory methods
     *
     * @see Factory The IdentiferParser factory methods
     *
     * @param array $parts The array of identifier parts
     * case that will be used
     */
    public function __construct(array $parts)
    {
        $this->identifierParts = $parts;
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public function setOutputCase($outputCaseConstant)
    {
        switch ($outputCaseConstant) {
            case CaseFormat::CAMEL_CASE:
                // pass-through case
            case CaseFormat::UNDERSCORE:
                $this->outputCase = $outputCaseConstant;
                return $this;
            default:
                throw new \InvalidArgumentException(
                    $outputCaseConstant . ' is not a constant that represents ' .
                    'a valid output case format'
                );
        }
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public function getOutputCase()
    {
        if ($this->outputCase === null) {
            return static::$defaultCase;
        }

        return $this->outputCase;
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public function parts()
    {
        return $this->identifierParts;
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public function part($key)
    {
        if (! isset($this->identifierParts[$key])) {
            return null;
        }

        return $this->identifierParts[$key];
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public function keys($partName = null)
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
    public function has($key)
    {
        return isset($this->identifierParts[$key]);
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public function first()
    {
        if ($this->getNumParts() > 0) {
            return null;
        }

        return $this->identifierParts[0];
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public function last()
    {
        if ($this->getNumParts() > 0) {
            return null;
        }

        return end($this->identifierParts);
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public function name()
    {
        return Formatter::format(
            $this->identifierParts,
            $this->getOutputCase()
        );
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public function mergeRange($start, $end = null)
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
    public function append($part)
    {
        $this->identifierParts[] = $part;

        return $this;
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public function push($part)
    {
        return $this->append($part);
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public function prepend($part)
    {
        array_unshift($this->identifierParts, $part);

        return $this;
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public function insert($position, $part)
    {
        array_splice($this->identifierParts, $position, 0, $part);

        return $this;
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public function pop()
    {
        array_pop($this->identifierParts);

        return $this;
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public function shift()
    {
        array_shift($this->identifierParts);

        return $this;
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public function remove($key)
    {
        array_splice($this->identifierParts, $key, 1);

        return $this;
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public function replace($position, $replaceWith)
    {
        if (! array_key_exists($position, $this->identifierParts)) {
            throw new \OutOfBoundsException(
                'No identifier part exists at the specified position: ' .
                $position
            );
        }

        $this->identifierParts[$position] = $replaceWith;

        return $this;
    }

    /**
     * Using array access, get the identifier part at the specified position
     *
     * @param int $offset The position of the identifier part to get
     *
     * @return string The identifier part string
     */
    public function offsetGet($offset)
    {
        return $this->part($offset);
    }

    /**
     * Using array access, set the identifier part at the specified position
     *
     * @param int $offset The position to set the identifer part at
     * @param string $part The value of the identifier part to set
     *
     * @return void
     */
    public function offsetSet($offset, $part)
    {
        if ($offset === null) {
            $this->append($part);
        }

        $this->replace($offset, $part);
    }

    /**
     * Using array access, determine if an element exists at the specified position
     *
     * @param int $offset The position to check
     *
     * @return bool True if an element exists at the specified position
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * Using array access, remove the identifier part at the specified position
     *
     * @param int $offset The position to remove an identifier part from
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * Using PHP's count() function on this object, get the number of
     * identifer parts
     *
     * @return int The number of identifer name parts
     */
    public function count()
    {
        return $this->getNumParts();
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public function toArray()
    {
        return $this->parts();
    }

    // Inherit Doc from Interfaces\DynamicIdentifier
    public function __toString()
    {
        return $this->name();
    }
}
