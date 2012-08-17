# Petrinet

![Build status](https://secure.travis-ci.org/florianv/Petrinet.png)

A simple Petri Net API written in PHP.

At this moment, only [Basic Petri Nets](https://github.com/florianv/Petrinet#basic-petri-nets) are supported.

1. [Requirements](https://github.com/florianv/Petrinet#requirements)
2. [Installation](https://github.com/florianv/Petrinet#installation)
3. [Running unit tests](https://github.com/florianv/Petrinet#running-unit-tests)
4. [Using the API](https://github.com/florianv/Petrinet#using-the-api)
   * [Basic Petri Nets](https://github.com/florianv/Petrinet#basic-petri-nets)
     * [Key elements](https://github.com/florianv/Petrinet#key-elements)
     * [Creating a simple Petri Net](https://github.com/florianv/Petrinet#creating-a-simple-petri-net)
     * [Executing a Petri Net](https://github.com/florianv/Petrinet#executing-a-petri-net)
     * [Creating Custom Transitions](https://github.com/florianv/Petrinet#creating-custom-transitions)
   * [Colored Petri Nets] (https://github.com/florianv/Petrinet#colored-petri-nets)
     * [Key elements](https://github.com/florianv/Petrinet#key-elements-1)
     * [Creating a simple Petri Net](https://github.com/florianv/Petrinet#creating-a-simple-petri-net-1)
     * [Executing a Petri Net](https://github.com/florianv/Petrinet#executing-a-petri-net-1)
     * [Arc Expressions](https://github.com/florianv/Petrinet#arc-expressions)
     * [Custom types](https://github.com/florianv/Petrinet#custom-types)
     * [Object types](https://github.com/florianv/Petrinet#object-types)
5. [Some Future work](https://github.com/florianv/Petrinet#some-future-work)

## Requirements

Requires PHP 5.3.1+.

## Installation

For playing around or reproducing the example, clone the repository and copy the `www/index.dist.php` in a `www/index.php` file.

## Running unit tests

Cd to the Petrinet root folder, and type the command : `phpunit`

## Using the API

### Basic Petri Nets

You must be familiar with Basic Petri Nets in order to use the software : [Powerpoint](https://docs.google.com/viewer?a=v&q=cache:gs71sC2dCVcJ:ece.ut.ac.ir/Classpages/S86/ECE658/slides/Petri.ppt+&hl=fr&gl=fr&pid=bl&srcid=ADGEESgto4sjEPQ3FCX3tIW4ajqIF6tCDtE_oa3CwfSeOVvJ2HH65WnNWVmuiFrtHV_44SL8SVCpF-hCu3tQbSA70JOcu-Ux7viExjMlbe_4vjZH5CJLzS-Y23A-JovpuOuX6EVLXvST&sig=AHIEtbSYTNcj5PFZ8tjEqxbSovtnIL5yvQ)

#### Key elements

```php
<?php

// Creating a Place.
$place = new PNPlace();

// Creating a Transition.
$transition = new PNTransition();

// Creating a Token.
$token = new PNToken();

// Marking a Place (adding token(s) to it).
$place->addToken($token);

// Creating an Arc : from a Place to a Transition.
$arc = new PNArc($place, $transition);

// Creating an Arc : from a Transition to a Place.
$arc = new PNArc($transition, $place);
```

#### Creating a simple Petri Net

In order to create a Petri Net, you must use the `PNPetrinet` class.

This class allows to create the elements presented above, and easily connect a Place to a Transition or vice-versa.

I have constrained the system to have one Start Place as top level Node, and you must pass this Place to the `PNPetrinet` object, as shown in the example :

```php
<?php

// Creating a new Petrinet called 'MyPetrinet'.
$net = new PNPetrinet('MyPetrinet');

// Creating a Start Place.
$placeStart = $net->createPlace();

// Creating an End Place.
$placeEnd = $net->createPlace();

// Creating a Transition.
$transition = $net->createTransition();

// Creating a Token.
$token = $net->createToken();

// Adding the Token in the start Place.
$placeStart->addToken($token);

// Connecting the start Place to the Transition.
$net->connect($placeStart, $transition);

// Connecting the Transition to the end Place.
$net->connect($transition, $placeEnd);

// Passing the Start Place to the Petri Net object.
$net->setStartPlace($placeStart);
```

#### Visualizing a Petri Net

You can visualize your Petri Net definition using the [GraphViz](http://www.graphviz.org/Download..php) software.

```php
<?php

// Create a Viewer visitor instance.
$viewer = new PNVisitorViewer;

// Call the method accept of your Petri Net object with the Viewer as param.
$net->accept($viewer);

// Displaying your Petri Net as a Graphviz formatted string.
echo $viewer;

// Creating a .dot file containing the Graphviz formatted string.
// If the folder permission is set correctly, it will create a /test/example1.dot file which is ready to be opened
// by the Graphviz software.
$viewer->toFile('/test/example1');
```
Example with the last Petri Net : 

<img src="http://voutzinos.florian.free.fr/example1.png">

#### Executing a Petri Net

Once your Petri Net is created you can execute it using the`PNEngine` class.

```php
<?php

// Instanciating the Engine.
$engine = PNEngine::getInstance();

// Passing the Petri Net object to the engine.
$engine->setNet($net);

// Starting the execution.
$engine->start();
```

The Transition is fired and a token is produced in the end place.

<img src="http://voutzinos.florian.free.fr/example2.png">

More commands :

```php
<?php

// Stopping the execution.
$engine->stop();

// Resuming the execution.
$engine->resume();
```
#### A more complex example

```php
<?php
$net = new PNPetrinet('MyPetrinet');

$place1 = $net->createPlace();
$place2 = $net->createPlace();
$place3 = $net->createPlace();
$place4 = $net->createPlace();

$place1->addToken(new PNToken);

$transition1 = $net->createTransition();
$transition2 = $net->createTransition();
$transition3 = $net->createTransition();

// Connecting the graph (order not important).
$net->connect($place1, $transition1);
$net->connect($place1, $transition3);
$net->connect($transition1, $place2);
$net->connect($transition3, $place4);
$net->connect($place2, $transition2);
$net->connect($place4, $transition2);
$net->connect($transition2, $place3);

$net->setStartPlace($place1);
```

<table>
  <tr>
    <th>Before execution</th><th>After firing the 3 transitions</th>
  </tr>
  <tr>
    <td><img src="http://voutzinos.florian.free.fr/hard.png" width="216" height="295"></td><td><img src="http://voutzinos.florian.free.fr/hard3.png" width="216" height="295"></td>
  </tr>
</table>

#### Creating Custom Transitions

You can create your own transitions by extending the `PNTransition` class, in order to perform custom execution when the Transition is fired.

```php
<?php

class MyTransition1 extends PNTransition
{
	/**
	 * Perform custom execution.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function doExecute()
	{
		echo 'Firing Transition 1';
	}
}

class MyTransition2 extends PNTransition
{
	/**
	 * Perform custom execution.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function doExecute()
	{
		echo 'Firing Transition 2';
	}
}

$net = new PNPetrinet('MyPetrinet');

// Creating 3 places.
$placeStart = $net->createPlace();
$placeMiddle = $net->createPlace();
$placeEnd = $net->createPlace();

// Instanciating your custom Transitions.
$transition1 = new MyTransition1;
$transition2 = new MyTransition2;

// Adding a Token in the start Place.
$placeStart->addToken(new PNToken);

// Connecting the graph.
$net->connect($placeStart, $transition1);
$net->connect($transition1, $placeMiddle);
$net->connect($placeMiddle, $transition2);
$net->connect($transition2, $placeEnd);

// Passing the start place to the net.
$net->setStartPlace($placeStart);

// Executing the net.
$engine = PNEngine::getInstance()
	->setNet($net)
	->start();
```

Representation : 

<img src="http://voutzinos.florian.free.fr/example3.png" width="103" height="295">

### Colored Petri Nets

Colored Petri Nets are not supported for execution atm, but you can get familiar with the future api (despite it will probably change a bit).

In colored Petri Nets, tokens can carry data (color), place and Transition have a Color Set and arc expressions
can manipulate the token colour when they transit through the arc.

Documents :

1) www.cs.au.dk/~cpnbook/slides/CPN2.ppt  
2) www.daimi.au.dk/~kjensen/papers_books/use.pdf  

### Key elements

```php
<?php

// Creating a Color Set : a Color Set is a tuple of types.
// The allowed types are integer, double, array, string, boolean.
$colorSet = new PNColorSet(array('integer', 'double'));

// Creating a Color compatible with the preceding set.
$color = new PNColor(array(1, 1.2));

// Creating a Colored Token.
$token = new PNToken($color);

// Creating a Place with a Color Set.
$place = new PNPlace($colorSet);

// Marking a Place.
$place->addToken($token);

// Creating a Transition with a Color Set.
$transition = new PNTransition($colorSet);
```

### Creating a simple Petri Net

```php
<?php

// Creating the Petri Net.
$net = new PNPetrinet('MyPetrinet');

// Creating a Color Set for the Place and Transition.
$colorSet = $net->createColorSet(array('integer', 'double'));

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

// Connecting the start Place and the Transition.
$arc = $net->connect($startPlace, $transition);

// Connecting the Transition and the end Place.
$arc = $net->connect($transition, $endPlace);

// Passing the Start Place to the Petri Net object.
$net->setStartPlace($placeStart);
```

### Executing a Petri Net

At this moment it is not possible to execute a colored Petri Net.

Two methods : enabling a transition and firing a transition for CPN need to be implemented, and it will work the same way
than for executing Basic Petri Net.
http://ceur-ws.org/Vol-643/paper05.pdf

### Arc Expressions

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
		parent::__construct(array('integer', 'double'));
	}

	/**
     * Execute the expression.
     * If a token with a color (1, 2.2) transits through this arc, a new token with color (1+1, 2.2+1.5) = (2, 3.7)
     * will be produced after executing the expression.
     * The types of the values contained in the returned array, must match the output place/transition color set.
     */
	public function execute(array $arguments)
	{
		return array($arguments[0]+1, $arguments[1]+1.5);
	}
}
```

### New types

The default supported types are : `integer`, `double (float)`, `array`, `boolean` and `string`.

Custom types and Object types are special types in the system.

Once declared and registered, they can be used in Color Set, Colors and arc expressions.

#### Custom types

A custom type is a subset of the above mentionned types.

Example : I want to create the type of integers equal or greater than 5.
It's a subset of the integers set.

For this, you must declarate the type by implementing the `PNType` interface and declaring two methods.

```php
<?php

class IntegerGteFive implements PNType
{
	/**
	 * Check the given variable matches the type.
	 *
	 * @param   integer  $var  A PHP variable.
	 *
	 * @return  boolean  True if the variable matches, false otherwise.
	 */
    public function check($var)
    {
    	return $var >= 5;
    }

    /**
     * Return a value compatible with this type.
     *
     * @return  integer  A value compatible with this type.
     */
    public function test()
    {
    	return 8;
    }
}
```

Once the class is declared you can register the type in the system.

```php
<?php

// Get an instance of the IntegerGteFive class.
$myType = new IntegerGteFive;

// Get an instance of the Type Manager.
$typeManager = new PNTypeManager();

/**
 * Registering the new type in the system.
 * The first param is the name of the new type (does no need to match the class name).
 * The second param the parent type.
 * The third param, an instance of the IntegerGteFive class.
 */
$typeManager->registerCustomType('IntegerGteFive', 'integer', $myType);

// Creating a Petri Net and injecting the type manager.
$net = new PNPetrinet('Test', $typeManager);

// Now the custom type is recognized by the system.
$colorSet = $net->createColorSet(array('IntegerGteFive'));
$token = new PNToken(new PNColor(array(8));
$place = $net->createPlace($colorSet);
$place->addToken($token);
```

### Object types

An object type is the name of a php class.
You can register a given class name as an 'object type' in the system.

It allows tokens to transport instances of a given class.

```php
<?php

// Get an instance of the Type Manager.
$typeManager = new PNTypeManager();

// Register the object type.
$typeManager->registerObjectType('MyClass');

// Creating a Petri Net and injecting the type manager.
$net = new PNPetrinet('Test', $typeManager);

// Now your object type is recognized by the system.
$colorSet = $net->createColorSet(array('MyClass'));
$token = new PNToken(new PNColor(array(new MyClass));
$place = $net->createPlace($colorSet);
$place->addToken($token);
```

## Some Future work

- Finish the Colored Petri Net execution.
- Database storage and loading of a Petri Net at a given state.
- Use the Visitor Pattern to traverse the graph and validate the Petri Net definition according some Petri Net properties.
- Allow mapping to BPMN : [Document](https://docs.google.com/viewer?a=v&q=cache:DST7lP9yJcoJ:eng.alexu.edu.eg/~elmongui/papers/bpmnFormalization.pdf+&hl=fr&gl=fr&pid=bl&srcid=ADGEESgZJ65Z-tgQ1WXYW2CtkCv2M_pdEGRRvFl-blX8ZBxg79-N9pm8emclxiLBcms0T8oFRrmXKr2migwk9GeH0vusODYs7jOhydn-q4uSmXxzIyIicRgbX34_VtSmohp6i6ld9csW&sig=AHIEtbQhN7uhnEZxSJp7YznCohfRTS3fTQ&pli=1)
- BPMN/XPDL parser to import workflow definitions.
