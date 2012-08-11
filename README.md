Petrinet
========

A simple Colored Petri Net Framework written in PHP.

## Requirements

You must be familiar with Colored Petri Nets.

See :
(www.daimi.au.dk/~kjensen/papers_books/use.pdf)

## Using the framework.

### Creating a Color Set.

```php
<?php

// Creating a set that can only contain Colors where the first element is an integer,
// and the second element a float.
$colorSet = new PNColorSet(array('integer', 'float'));
```

### Creating a Color.

```php
<?php

// Creating a color compatible with the preceding set.
$color = new PNColor(array(1, 1.2));
```

### Creating a Place.

```php
<?php

// Creating a simple place.
$place = new PNPlace();

// Creating a Place with a color set.
$colorSet = new PNColorSet(array('integer', 'float'));
$place = new PNPlace($colorSet);
```

### Creating a Transition.

```php
<?php

// Creating a simple Transition.
$transition = new PNTransition();

// Creating a Place with a color set.
$colorSet = new PNColorSet(array('integer', 'float'));
$transition = new PNTransition($colorSet);
```
