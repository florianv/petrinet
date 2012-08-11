Petrinet
========

A simple colored Petri net Framework written in PHP.

Requirements
============

You must be familiar with Colored Petri Nets.

See :
(www.daimi.au.dk/~kjensen/papers_books/use.pdf)

Creating a color set.
=====================

```php
<?php

// Creating a set that can contains only 2-tuples where the first element is an integer,
// and the second element a float.
$colorSet = new PNColorSet(array('integer', 'float'));
```
