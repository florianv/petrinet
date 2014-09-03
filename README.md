# Petrinet [![Build status][travis-image]][travis-url] [![Version][version-image]][version-url] [![License][license-image]][license-url]

This framework allows to build, vizualize and execute [Petrinets](http://en.wikipedia.org/wiki/Petri_net)
which can be used to build workflow engines. It provides the core domain model of basic Petrinets that can be persisted
using your favorite ORM as well as services to manage its execution.

## Installation

The recommended way to install Petrinet is via [Composer](https://getcomposer.org).

Add this line to your `composer.json` file:

```json
{
    "require": {
        "florianv/petrinet": "~2.0"
    }
}
```

Tell Composer to update the dependency by running:

```bash
$ php composer.phar update florianv/petrinet
```

## Documentation

[Read the documentation for master](https://github.com/florianv/petrinet/blob/master/docs/documentation.md)

[Read the documentation for the 1.0 version](https://github.com/florianv/petrinet/blob/1.0/docs/documentation.md)

## License

[MIT](https://github.com/florianv/petrinet/blob/master/LICENSE)

[travis-url]: https://travis-ci.org/florianv/petrinet
[travis-image]: http://img.shields.io/travis/florianv/petrinet.svg?style=flat-square

[license-url]: https://packagist.org/packages/florianv/petrinet
[license-image]: http://img.shields.io/packagist/l/florianv/petrinet.svg?style=flat-square

[version-url]: https://packagist.org/packages/florianv/petrinet
[version-image]: http://img.shields.io/packagist/v/florianv/petrinet.svg?style=flat-square
