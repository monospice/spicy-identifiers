Spicy Identifiers
=================

[![Build Status](https://travis-ci.org/monospice/spicy-identifier-tools.svg?branch=master)](https://travis-ci.org/monospice/spicy-identifier-tools)

**An easy way to parse and manipulate identifier names, such as dynamic method
names.**

This package is helpful when working with dynamic identifier names such
as dynamically accessed methods and variables/properties.

**Warning:** This package is under heavy development and should be considered
**incomplete** and **unstable**.

Simple Example
--------------

```php
// Call a dynamic method:
$someClass->callSomeDynamicMethod('some argument');

// The dynamic method call is handled by the __call() magic method of a class.
// $methodCalled is the name of the dynamic method: "callDynamicMethod"
public function __call($methodCalled, array $arguments)
{
    // Use Spicy Identifiers to work with the dynamic method
    $method = DynamicMethod::parse($methodCalled);

    $method->replace(0, 'get')->replace(2, 'Variable');
    // The dynamic method name is now "getSomeDynamicVariable"

    // Check if the method exists on this class
    if (! $method->existsOn($this)) {
        throw new \BadMethodCallException($methodCalled . ' does not exist');
    }

    // Check that the method includes the word "Dynamic" in the name,
    // then call the method represented by the name and return that value
    if ($method->has(1) && $method[1] === 'Dynamic') {
        return $method->callIn($this, $arguments);
    }

    throw new \BadMethodCallException($methodCalled . ' is not supported');
}
```

Installation
------------

```
$ composer require monospice/spicy-identifiers
```

If you're autoloading classes (hopefully):

```php
use Monospice\SpicyIdentifiers\DynamicVariable;
use Monospice\SpicyIdentifiers\DynamicFunction;
use Monospice\SpicyIdentifiers\DynamicMethod;
use Monospice\SpicyIdentifiers\DynamicClass;
use Monospice\SpicyIdentifiers\Tools\CaseFormat;
```

Types of Identifiers
--------------------

This package provides different classes for working with various types of
identifiers:

- `DynamicIdentifier`: A generic class that manipulates identifier names but
provides no additional functionality
- `DynamicMethod`: Provides methods and defaults that expedite the process of
working with class methods
- `DynamicFunction`: Provides methods and defaults that expedite the process of
working with global functions
- `DynamicVariable`: Provides methods and defaults that expedite the process of
working with variables
- `DynamicClass`: Provides methods and defaults that expedite the process of
working with classes

Parsing Identifer Names
-----------------------

To begin working with an identifier string, such as a method name, use one of
the package's factory methods to parse it into the object:

```php
$method = DynamicMethod::parse('aMethodName');
$someVar = DynamicVariable::parse('aVariableName');
$class = DynamicClass::parse('AClassName');

$method->parts(); // array('a', 'Method', 'Name');
```

The `::parse()` method uses the default case format for the identifer type
represented by each of the package's classes. To parse an identifier in a
specific format, use the respective parsing method:

```php
$method = DynamicMethod::parseFromUnderscore('a_method_name');
$method->parts(); // array('a', 'method', 'name');
```

More information about identifier case formats below.

Identifier Manipulation
-----------------------

After parsing an identifier, one can use this package to manipulate the parts.
Let's use this DynamicIdentifier instance for the following examples:

```php
$identifier = DynamicIdentifier::parse('anIdentifierName');
```

At any time, you may retrieve the current identifier name:

**name()** - get the string representation of the entire identifier name

```php
$identifier->name();                    // "anIdentifierName"
```

Alternatively, you may cast the dynamic identifer instance to a string:

```php
echo $identifier;                       // "anIdentifierName"
```

### Getting Identifer Part Data

**parts()** - get an array of identifier part names

```php
$identifier->parts();                   // ['an', 'Identifier', 'Name']
$identifier->toArray();                 // an alias for parts()
```

**part()** - get the string value of the specified identifier part

```php
$identifer->part(1);                    // "Identifier"
```

Alternatively, use array access to get the value:

```php
$identifier[1];                         // "Identifier"
```

**first()** - get the value of the first identifier part

```php
$identifier->first();                   // "an"
```

**last()** - get the value of the last identifier part

```php
$identifier->last();                    // "Name"
```

**keys()** - get an array of identifier part indices

```php
$identifier->keys();                    // [0, 1, 2]
$identifier->keys('Name');              // [2]
```

**has()** - check if the identifier contains a part at the specified index

```php
$identifier->has(1);                    // true
```

One may use array access for the above as well:

```php
isset($identifier[1]);                  // true
```

**getNumParts()** - get the number of identifier parts

```php
$identifier->getNumParts();             // 3
```

Alternatively, use PHP's count() function to get the number of identifier parts:

```php
count($identifier);                     // 3
```

### Adding Parts

**append()** - add a part to the end of the identifier

```php
$identifier->append('last');            // "anIdentifierNameLast"
$identifier->push('last');              // alias for append()
```

Alternatively, use array access to push a part to the end of the identifier:

```php
$identifier[] = 'last';
```

**prepend()** - add a part to the beginning of the identifier

```php
$identifier->prepend('first');          // "firstAnIdentifierName"
```

**insert()** - add a part to the specified position in the identifier

```php
$identifier->insert(1, 'insert');       // "anInsertIdentifierName"
```

### Removing Parts

**pop()** - remove a part from the end of the identifier

```php
$identifier->pop();                     // "anIdentifier"
```

**shift()** - remove a part from the beginning of the identifier

```php
$identifier->shift();                   // "identifierName"
```

**remove()** - remove a part at the specified position of the identifier

```php
$identifier->remove(1);                 // "anName"
```

### Replacing Parts

**replace()** - replace a part at the specified position of the identifier

```php
$identifier->replace(2, 'String');      // "anIdentifierString"
```

Alternatively, use array access to replace a part at the specified index:

```php
$identifier[2] = 'String';              // "anIdentifierString"
```

### Merging Parts

Merging parts doesn't change the output string, but combines parts of the
internal array. This is useful for other operations.

**mergeRange()** - combine identifier parts between the specified positions

```php
$identifier = DynamicIdentifier::parse('anIdentifierName');

echo $identifier->mergeRange(1, 2);     // "anIdentifierName"
$identifier->parts();                   // array(
                                        //     0 => "an",
                                        //     1 => "IdentifierName"
                                        // )
```

If one does not specify an ending position, any remaining parts after the
starting position will be merged.

```php
$identifier->mergeRange(1)->parts();    // array(
                                        //     0 => "an",
                                        //     1 => "IdentifierName"
                                        // )
```

Dynamic Methods
---------------

The `DynamicMethod` class adds functionality for working with an underlying
class method that corresponds to the parsed method name.

**existsIn()** - check if the represented method exists in the given context

```php
$method->existsIn('SomeClass');
$method->existsIn($this);
$method->exists($this); // alias for existsIn()
```

**callIn()** - call the method represented by the parsed method name in the
given context

```php
$returnValue = $method->callIn('SomeClass', ['arg1', 'arg2']);
$returnValue = $method->callIn($this, ['arg1', 'arg2']);
$returnValue = $method->call($this, ['arg1']); // alias for callIn()
```

Method Chaining
---------------

Methods that do not return an output value can be chained:

```php
$returnValue = DynamicMethod::parse('aDynamicMethod')
    ->append('last')->if('Method')
    ->mergeRange(1, 2)
    ->call($this);
```

Identifier Case Formats
-----------------------

Each class uses a default case format to parse and output identifiers. These
formats are constants set on the `Tools\CaseFormat` class.

For more information see the
[Spicy Identifier Tools](https://github.com/monospice/spicy-identifier-tools)
package which this package includes automatically.

Identifier Class         | Default Case Format            | Example
------------------------ | ------------------------------ | ------------------
`DynamicVariable`        | `CaseFormat::CAMEL_CASE`       | variableName
`DynamicMethod`          | `CaseFormat::CAMEL_CASE`       | methodName
`DynamicClass`           | `CaseFormat::UPPER_CAMEL_CASE` | ClassName
`DynamicFunction`        | `CaseFormat::UNDERSCORE`       | function_name
`DynamicIdentifier`      | `CaseFormat::CAMEL_CASE`       | identifierName

To override this default formatting, parse the identifier using one of the
dedicated methods and/or set the output formatting explicitly:

```php
// parses and output with the default case format (camel case)
$identifier = DynamicIdentifier::parse('identifierName');

// parse and output with an explicit case format
$identifier = DynamicIdentifier::parseFromUnderscore('identifier_name');

// parse with an explicit format, and set a different output format
$identifier = DynamicIdentifier::parseFromUnderscore('identifier_name')
    ->setOutputFormat(CaseFormat::UPPER_CAMEL_CASE);
```

Acronyms in Identifier Names
----------------------------

Sometimes identifier names contain acronyms, such as JavaScript's
`XMLHttpRequest`. The parsing methods preserve these acronyms:

```php
$method = DynamicMethod::parse('XMLHttpRequest')
$method->parts();   // array('XML', 'Http', 'Request');
```

However, the output methods will not preserve these acronyms unless one sets
an output format with acronyms:

```php
$method->name();    // "xmlHttpRequest"
$method
    ->setOutputFormat(CaseFormat::CAMEL_CASE_WITH_ACRONYMS)
    ->name();       // "XMLHttpRequest"
```

This behavior provides flexibility when converting or normalizing identifier
names.

Identifiers with Mixed Case Formats
-----------------------------------

Although mixed case identifiers are not recommended in practice, one may use
the `::parseFromMixedCase()` method to parse identifiers that contain multiple
cases:

```php
// parseFromMixedCase($identiferString, $arrayOfCases);

DynamicIdentifier::parseFromMixedCase('aMixed_case-identifier', [
    CaseFormat::CAMEL_CASE,
    CaseFormat::UNDERSCORE,
    CaseFormat::HYPHEN,
])
    ->parts(); // array('a', 'Mixed', 'case', 'identifier');
```

The package does not provide support to output identifiers in a mixed format.
Any output methods will format the output string using the default format
unless explicitly specified (see preceding section).

Extended ASCII Identifiers (Experimental)
-----------------------------------------

PHP supports extended ASCII characters in identifier names. For example, the
character `ä` in:

```php
// From the php.net manual:
$täyte = 'mansikka';    // valid; 'ä' is (Extended) ASCII 228.
```

When parsing identifiers by underscore or hyphen, these characters have no
effect. However, camel case identifiers may include words that are delimited
by extended ASCII characters, such as `änÏdentifierNáme`.

The Spicy Identifiers package provides an **experimental** method to parse
these identifiers:

```php
DynamicIdentifier::parseFromCamelCaseExtended('änÏdentifierNáme')
    ->parts(); // array('än', 'Ïdentifier', 'Náme');
```

The consistency of this method depends on the character encoding of the source
files and the environment language and encoding settings. As a best practice,
one should avoid using extended ASCII characters in identifier names.

For more information, visit the PHP Manual:
http://php.net/manual/en/language.variables.basics.php

Testing
-------

The Spicy Identifiers package uses PHPSpec to test object behavior.

```bash
$ vendor/bin/phpspec run
```

License
-------

The MIT License (MIT). Please see the [LICENSE File](LICENSE) for more
information.
