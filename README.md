DEPRECATED: Similar interfaces have been added to [wikibase/data-model-services](https://github.com/wmde/WikibaseDataModelServices) and continue to be maintained as part of that library.

# Wikibase TermStore

[![Build Status](https://travis-ci.org/wmde/wikibase-term-store.svg?branch=master)](https://travis-ci.org/wmde/wikibase-term-store)
[![Latest Stable Version](https://poser.pugx.org/wikibase/term-store/version.png)](https://packagist.org/packages/wikibase/term-store)
[![Download count](https://poser.pugx.org/wikibase/term-store/d/total.png)](https://packagist.org/packages/wikibase/term-store)

Tiny Wikibase library that defines interfaces for persisting terms of Items and Properties.

## Usage

Real implementations of the interface can be found in
[dependent packages](https://packagist.org/packages/wikibase/term-store/dependents).

This library does provide some trivial implementations, mainly to facilitate testing.

* `InMemoryPropertyTermStore` - simple in memory Fake
* `ThrowingPropertyTermStore` - throws an exception when one of its methods is invoked
* `InMemoryItemTermStore` - simple in memory Fake
* `ThrowingItemTermStore` - throws an exception when one of its methods is invoked

## Installation

To use the Wikibase TermStore library in your project, simply add a dependency on wikibase/term-store
to your project's `composer.json` file. Here is a minimal example of a `composer.json`
file that just defines a dependency on wikibase/term-store 1.x:

```json
{
    "require": {
        "wikibase/term-store": "~1.0"
    }
}
```

## Development

Start by installing the project dependencies by executing

    composer update

You can run the tests by executing

    composer test
    
You can run the style checks by executing

    composer cs
    
To run all CI checks, execute

    composer ci
    
You can also invoke PHPUnit directly to pass it arguments, as follows

    vendor/bin/phpunit --filter SomeClassNameOrFilter
