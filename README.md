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

// Creating a Colored Token.
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

### Creating a Petri Net
------------------------

```php
<?php

// Creating a Petri Net.
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

### Executing the Petri Net
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

