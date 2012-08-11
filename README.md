Petrinet
========

A simple colored Petri net Framework written in PHP.

## Requirements

You must be familiar with Colored Petri Nets.

See :
(www.daimi.au.dk/~kjensen/papers_books/use.pdf)

## Using the framework.

### Creating a color set

```php
<?php

// Creating a set that can only contain Colors where the first element is an integer,
// and the second element a float.
$colorSet = new PNColorSet(array('integer', 'float'));
```

### Creating a color

```php
<?php

// Creating a color compatible with the preceding set.
$color = new PNColor(array(1, 1.2));
```
