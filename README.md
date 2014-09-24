Bluz, a lightweight PHP Framework
=================================
Easy to setup, easy to use.

## Status

This version of Bluz not compatible with old code base. In mind of Author, this is Bluz 2.0 or something like that.

The main changes(many of this don't implemented yet):

1. Added ServiceManager that must replace all Singletons (cause Singleton is anti-pattern, and Singleton are not flexible).
2. Added ModuleManager that must be used for loading your code base and other third-party components.
3. New Application class (one for all application, init must be in Modules)
4. ...

This list may be extended

## Achievements

[![Build Status](https://secure.travis-ci.org/bluzphp/framework.png?branch=master)](https://travis-ci.org/bluzphp/framework)
[![Dependency Status](https://www.versioneye.com/php/bluzphp:framework/badge.png)](https://www.versioneye.com/php/bluzphp:framework)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bluzphp/framework/badges/quality-score.png?s=4fb36e6e0c742699777d2586ed14a0063a55ca62)](https://scrutinizer-ci.com/g/bluzphp/framework/)
[![Coverage Status](https://coveralls.io/repos/bluzphp/framework/badge.png?branch=master)](https://coveralls.io/r/bluzphp/framework?branch=master)

[![Latest Stable Version](https://poser.pugx.org/bluzphp/framework/v/stable.png)](https://packagist.org/packages/bluzphp/framework)
[![Total Downloads](https://poser.pugx.org/bluzphp/framework/downloads.png)](https://packagist.org/packages/bluzphp/framework)

[![License](https://poser.pugx.org/bluzphp/framework/license.svg)](https://packagist.org/packages/bluzphp/framework)

## Installation

The best way is setup the [skeleton][1] application

## Usage

In our [wiki][2] you can found description of every package

## License

Read [MIT LICENSE][3] file

[1]: https://github.com/bluzphp/skeleton
[2]: https://github.com/bluzphp/framework/wiki
[3]: https://raw.github.com/bluzphp/framework/master/LICENSE.md