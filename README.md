# Petrinet

A simple Colored Petri Net Framework written in PHP.

## Requirements

You must be familiar with Colored Petri Nets.

1) www.cs.au.dk/~cpnbook/slides/CPN2.ppt  
2) www.daimi.au.dk/~kjensen/papers_books/use.pdf

## Using the framework

### The elements
----------------

#### Creating a Color Set

```php
<?php

// Creating a set that can only contain Colors where the first element is an integer,
// and the second element a float.
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

// Creating a Place with a Color Set.
$colorSet = new PNColorSet(array('integer', 'float'));
$place = new PNPlace($colorSet);

// Creating a Colored Token matching the place color set.
$color = new PNColor(array(1, 1.2));
$token = new PNToken($color);

// Adding the Token in the Place.
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
------------------------------

```php
<?php

// Creating the Petri Net.
$net = new PNPetrinet('MyPetrinet'); // Or $net = PNPetrinet::getInstance('MyPetrinet');

// Creating a Color Set for The Place and Transition.
$colorSet = new PNColorSet(array('integer', 'float'));

// Creating a Place.
$place = $net->createPlace($colorSet);

// Creating a Colored Token.
$token = new PNToken(new PNColor(1, 2.2));

// Adding the Token in the Place.
$place->addToken($token);

// Creating a Transition.
$transition = $net->createTransition($colorSet);

// Linking the Place and the Transition (order is important).
$arc = $net->connect($place, $transition);
```

### Executing a Petri Net
---------------------------

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

