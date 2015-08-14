Spicy Identifiers
=======

[![Build Status](https://travis-ci.org/monospice/spicy-identifier-tools.svg?branch=master)](https://travis-ci.org/monospice/spicy-identifier-tools)

**An easy way to parse and manipulate identifier names, such as dynamic method
names.**

This package is helpful when working with dynamic identifier names such
as dynamically accessed methods and variables/properties.

**Warning:** This package is under heavy development and should be considered
**incomplete** and **unstable**.

Simple Example
------

```php
// Call a dynamic method:
$someClass->callDynamicMethod('some argument');

// The dynamic method call is handled by the __call() magic method of a class.
// $methodCalled is the name of the dynamic method: "callDynamicMethod"
public function __call($methodCalled, array $arguments)
{
    // Use Spicy Identifiers to work with the dynamic method
    $method = DynamicMethod::parse($methodCalled);

    $method->replace(0, 'get')->replace(2, 'Variable');
    // The dynamic method name is now "getDynamicVariable"

    // Check if the method exists on this class
    if (! $method->existsOn($this)) {
        throw new \BadMethodCallException($methodCalled . ' does not exist');
    }

    // Check that the method includes the word "Dynamic" in the name,
    // then call the method represented by the name and return that value
    if ($method->hasPart(1) && $method->getPart(1) === 'Dynamic') {
        return $method->callOn($this, $arguments);
    }

    throw new \BadMethodCallException($methodCalled . ' is not supported');
}
```

Installation
-------

```
$ composer require monospice/spicy-identifiers
```

If you're autoloading classes (hopefully):

```php
use Monospice\SpicyIdentifiers\DynamicVariable;
use Monospice\SpicyIdentifiers\DynamicFunction;
use Monospice\SpicyIdentifiers\DynamicMethod;
use Monospice\SpicyIdentifiers\DynamicClass;
```

Types of Identifiers
-------

This package provides different classes for working with various types of
identifiers:

- `DynamicIdentifier`: A generic class that manipulates identifier names but
provides no additional functionality
- `DynamicMethod`: Provides methods and defaults that expedite the process of
working with methods
- `DynamicFunction`: Provides methods and defaults that expedite the process of
working with functions
- `DynamicVariable`: Provides methods and defaults that expedite the process of
working with variables
- `DynamicClass`: Provides methods and defaults that expedite the process of
working with classes

Parsing Identifer Names
-------

To begin working with an identifier string, use one of the factory methods to
parse it into the object:

```php
$method = DynamicMethod::parse('aMethodName');
$someVar = DynamicVariable::parse('aVariableName');
$class = DynamicClass::parse('AClassName');

$method->getParts(); // array('a', 'Method', 'Name');
```

The `::parse()` method uses the default case format for the identifer type. To
parse an identifier in a specific format, use the respective parsing method:

```php
$method = DynamicMethod::parseFromUnderscore('a_method_name');
$method->getParts(); // array('a', 'method', 'name');
```

More information about identifier case formats below.

Identifier Manipulation
-------

After parsing an identifier, one can use this package to manipulate the parts:

**Adding Parts**

```php
$identifier = DynamicIdentifier::parse('anIdentifier');

echo $identifier->append('last');       // "anIdentifierNameLast"
echo $identifier->prepend('first');     // "firstAnIdentifierName"
echo $identifier->insert(1, 'insert');  // "anInsertIdentifierName"
```

**Removing Parts**

```php
echo $identifier->pop();                // "anIdentifier"
echo $identifier->shift();              // "identifierName"
echo $identifier->remove(1);            // "anName"
```

**Replacing Parts**

```php
echo $identifier->replace(2, 'String'); // "anIdentifierString"
```

**Merging Parts**

Merging parts doesn't change the output string, but combines parts of the
internal array. This is useful for other operations.

```php
$identifier = DynamicIdentifier::parse('anIdentifierName');

echo $identifier->mergeRange(1, 2);     // anIdentifierName
$identifier->getParts();                // array(
                                        //     0 => 'an',
                                        //     1 => 'IdentifierName'
                                        // )
```

**If Clauses**

Additionally, each of the above methods supports an "if" clause which will
only perform the preceding operation if the identifier part matches the given
string.

```php
echo $identifier->shift()->if('an');      // "identifierName"
echo $identifier->insert(1)->if('nope'); // "anIdentifierName"
echo $identifier->mergeRange->if([      // "anIdentifierName"
    1 => 'Identifier',
    2 => nope
]);
$identifier->getParts();                // array(
                                        //     0 => 'an',
                                        //     1 => 'Identifier',
                                        //     2 => 'Name'
                                        // )
```

Method Chaining
-------

Methods that do not return an output value can be chained:

```php
$returnValue = DynamicMethod::parse('aDynamicMethod')
    ->append('last')->if('Method')
    ->mergeRange(1, 2)
    ->call($this);
```

Identifier Case Formats
-------

Each class uses a default case format to parse and output identifiers. These
formats are constants set on the `Tools\CaseFormat` class.

For more information see the
[Spicy Identifier Tools](https://github.com/monospice/spicy-identifier-tools)
package.

Identifier Class         | Default Case Format            | Example
------------------------ | ------------------------------ | ------------------
`DynamicVariable`        | `CaseFormat::CAMEL_CASE`       | variableName
`DynamicMethod`          | `CaseFormat::CAMEL_CASE`       | methodName
`DynamicClass`           | `CaseFormat::UPPER_CAMEL_CASE` | ClassName
`DynamicFunction`        | `CaseFormat::UNDERSCORE`       | function_name
`DynamicIdentifier`      | `CaseFormat::CAMEL_CASE`       | identifierName

To override this default formatting, parse the identifier using one of the
dedicated method and/or set the output formatting explicitly:

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
-------
Sometimes identifier names contain acronyms, such as JavaScript's
`XMLHttpRequest`. The parsing methods preserve these acronyms:

```php
$method = DynamicMethod::parse('XMLHttpRequest')
$method->getParts(); // array('XML', 'Http', 'Request');
```

However, the output methods will not preserve these acronyms unless one sets
an output format with acronyms:

```php
$method->getName(); // "xmlHttpRequest"
$method
    ->setOutputFormat(CaseFormat::CAMEL_CASE_WITH_ACRONYMS)
    ->getName();    // "XMLHttpRequest"
```

This behavior provides flexibility when converting or normalizing identifier
names.

Identifiers with Mixed Case Formats
-------
Although mixed case identifiers are not recommended in practice, one may use
the `::parseFromMixedCase()` method to parse identifiers that contain multiple
cases:

```php
// ::parseFromMixedCase($identiferString, $arrayOfCases);

DynamicIdentifier::parseFromMixedCase('aMixed_case-identifier', [
    CaseFormat::CAMEL_CASE,
    CaseFormat::UNDERSCORE,
    CaseFormat::HYPHEN,
])
    ->getParts(); // array('a', 'Mixed', 'case', 'identifier');
```

The package does not provide support to output identifiers in a mixed format.
Any output methods will format the output string using the default format
unless explicitly specified (see preceding section).

Extended ASCII Identifiers (Experimental)
-------

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
    ->getParts(); // array('än', 'Ïdentifier', 'Náme');
```

The consistency of this method depends on the character encoding of the source
files and the environment language and encoding settings. As a best practice,
one should avoid using extended ASCII characters in identifier names.

For more information, visit the PHP Manual:
http://php.net/manual/en/language.variables.basics.php

Testing
-------

The Spicy Identifiers package uses PHPUnit to test input variations and
PHPSpec for object behavior.

``` bash
$ phpunit
$ vendor/bin/phpspec run
```

License
-------

The MIT License (MIT). Please see the [LICENSE File](LICENSE) for more
information.
