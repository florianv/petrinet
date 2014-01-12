# Contributing

## Code Style

We use the [PSR2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) standard.

[PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) can be used to help developers achieve PSR-2 compliance in any contributed code. 

### Running PHP CodeSniffer

- Install [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer#installation).
- Execute `phpcs --standard=psr2 src/Petrinet/*` from the project root directory.

## Unit tests

### Visualizing test cases

Some test cases from the `PetrinetProvider` can be visualized and executed using [Romeo](http://romeo.rts-software.org/).
They can be found [here](https://github.com/florianv/petrinet/tree/master/src/Petrinet/Tests/Fixtures/PetrinetProvider).

### Running the tests

- Install [PHPUnit](http://phpunit.de/manual/current/en/index.html)
- Copy `phpunit.xml.dist` to `phpunit.xml`
- Execute `phpunit` from the project root directory

## Running the build

- Install [Phing](http://www.phing.info/)
- Execute `phing` from the project root directory
