# Petrinet

![Build status](https://secure.travis-ci.org/florianv/Petrinet.png)

A simple Colored Petri Net API written in PHP.

1. [Requirements](https://github.com/florianv/Petrinet#requirements)  
2. [Installation](https://github.com/florianv/Petrinet#installation)  
3. [Running unit tests](https://github.com/florianv/Petrinet#running-unit-tests)  
4. [Using the API](https://github.com/florianv/Petrinet#using-the-api)
   * [The elements](https://github.com/florianv/Petrinet#the-elements)  
   * [Creating a simple Petri Net](https://github.com/florianv/Petrinet#creating-a-simple-petri-net)  
   * [Executing a Petri Net](https://github.com/florianv/Petrinet#executing-a-petri-net)
     
5. [Some Future work](https://github.com/florianv/Petrinet#some-future-work) 

## Requirements

Requires PHP 5.3.1+.

You must be familiar with Colored Petri Nets.

1) www.cs.au.dk/~cpnbook/slides/CPN2.ppt  
2) www.daimi.au.dk/~kjensen/papers_books/use.pdf

## Installation

* For playing around, clone the repository and copy the `www/index.dist.php` in a `www/index.php` file.

* For using it in Joomla, despite it's not recommanded yet, copy the content of the `src` dir in `libraries/joomla/petrinet`.
Then register the API to the Joomla autoloader by adding : `JLoader::registerPrefix('PN', '/path/to/libraries/joomla/petrinet');` in
`libraries/import.php`.

## Running unit tests

Cd to the Petrinet root folder, and type the command :

`phpunit`

## Using the API

### The elements

#### Creating a Color Set

```php
<?php

// Creating a set (of PHP types) that can only contain Colors (data) where the first element is an integer,
// and the second element a float.
// Atm the allowed types are : integer, float, boolean, array, string.
$colorSet = new PNColorSet(array('integer', 'float'));
```

#### Creating a Color

```php
<?php

// Creating a Color compatible with the preceding set.
$color = new PNColor(array(1, 1.2));
```

#### Creating a Token

```php
<?php

// Creating a simple Token.
$token = new PNToken();

// Creating a Colored token.
$color = new PNColor(array(1, 1.2));
$token = new PNToken($color);
```

#### Creating a Place

```php
<?php

// Creating a simple Place.
$place = new PNPlace();

// Creating a Place with a Color Set.
$colorSet = new PNColorSet(array('integer', 'float'));
$place = new PNPlace($colorSet);
```

#### Marking a Place

```php
<?php

// Creating a Colored Token matching the preceding place color set.
$color = new PNColor(array(1, 1.2));
$token = new PNToken($color);

// Adding the Token to the Place.
$place->addToken($token);
```

#### Creating a Transition

```php
<?php

// Creating a simple Transition.
$transition = new PNTransition();

// Creating a Transition with a Color Set.
$colorSet = new PNColorSet(array('integer', 'float'));
$transition = new PNTransition($colorSet);
```

#### Creating an Arc

```php
<?php

$place = new PNPlace();
$transition = new PNTransition();

// Creating an input Arc.
$inputArc = new PNArcInput($place, $transtion);

// Creating an output Arc.
$outputArc = new PNArcOutput($transition, $place);
```

#### Creating an Arc Expression

```php
<?php

/**
 * An expression manipulating the Token Color (data) 
 * when it transits through the arc.
 */
class MyExpression extends PNArcExpression
{
	/**
	 * Method to define the expression arguments.
	 * The arc expression arguments must match the input place/transition color set (or a sub-set of it).
	 */
	public function __construct()
	{
		parent::__construct(array('integer', 'float'));
	}
	
	/**
     * Execute the expression.
     * If a token with a color (1, 2.2) transit through this arc, a new token with color (1+1, 2.2+1.5) = (2, 3.7)
     * will be produced after executing the expression.
     * The types of the values contained in the returned array, must match the output place/transition color set.
     */
	public function execute(array $arguments)
	{
		return array($arguments[0]+1, $arguments[1]+1.5);
	}
}
```

### Creating a simple Petri Net

```php
<?php

// Creating the Petri Net.
$net = new PNPetrinet('MyPetrinet'); // Or $net = PNPetrinet::getInstance('MyPetrinet');

// Creating a Color Set for the Place and Transition.
$colorSet = new PNColorSet(array('integer', 'float'));

// Creating the start Place.
$startPlace = $net->createPlace($colorSet);

// Creating the end Place.
$endPlace = $net->createPlace($colorSet);

// Creating a Colored Token.
$token = new PNToken(new PNColor(1, 2.2));

// Adding the Token in the start Place.
$startPlace->addToken($token);

// Creating a Transition.
$transition = $net->createTransition($colorSet);

// Linking the start Place and the Transition (order is important : from the place to the transition).
$arc = $net->connect($startPlace, $transition);

// Linking the Transition and the end Place.
$arc = $net->connect($transition, $endPlace);
```

### Executing a Petri Net

```php
<?php

// Instanciating the Engine.
$engine = PNEngine::getInstance();

// Passing the Petri Net to the Engine.
$engine->setNet($net);

// Starting the execution.
$engine->start();

// Stopping the execution.
$engine->stop();

// Resuming the execution.
$engine->resume();
```

## Some Future work

- Allow arc expressions to return empty arrays (non matching output node color set) for if-else expressions.
- Improve the Transition enabling (binding) algorithm.
- Allow both colored and non-colored Petri nets creation.
- Database storage and loading of a Petri Net at a given state.
- Use the Visitor Pattern to traverse the graph and validate the Petri Net definition according to Petri Net properties.
- Allow mapping to BPMN : [Document](https://docs.google.com/viewer?a=v&q=cache:DST7lP9yJcoJ:eng.alexu.edu.eg/~elmongui/papers/bpmnFormalization.pdf+&hl=fr&gl=fr&pid=bl&srcid=ADGEESgZJ65Z-tgQ1WXYW2CtkCv2M_pdEGRRvFl-blX8ZBxg79-N9pm8emclxiLBcms0T8oFRrmXKr2migwk9GeH0vusODYs7jOhydn-q4uSmXxzIyIicRgbX34_VtSmohp6i6ld9csW&sig=AHIEtbQhN7uhnEZxSJp7YznCohfRTS3fTQ&pli=1)
- BPMN/XPDL parser to import workflow definitions.
