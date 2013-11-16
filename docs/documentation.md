# Documentation

## Creating a Petrinet

The easiest way to create a Petrinet is to use the `PetrinetBuilder` class providing a fluent API.

```php
<?php

use Petrinet\PetrinetBuilder;

// Instanciating the builder to create a Petrinet called "Network"
$builder = new PetrinetBuilder('Network');

// Adding an empty place identified by 'p1'
$builder->addPlace('p1');

// Adding a place with one token
$builder->addPlace('p1', 1);

// Adding a transition identified by 't1'
$builder->addTransition('t1');

// Connecting the place p1 to the transition t1
$builder->connectPT('p1', 't1');

// Connecting the transition t1 to the place p2
$builder->connectTP('t1', 'p2');

// Obtaining the resulting Petrinet
$petrinet = $builder->getPetrinet();
```

## Visualizing a Petrinet

### Using Graphviz

Firstly download and install [Graphviz](http://www.graphviz.org/).

```php
<?php

use Petrinet\Dumper\GraphvizDumper;

$dumper = New GraphvizDumper();

// Creating a file Network.dot ready to be opened by the Graphviz software
file_put_contents('Network.dot', $dumper->dump($petrinet));
```

## Execution

### Using the Engine

```php
<?php

use Petrinet\Engine\Engine;

// Instanciating the engine to execute the Petrinet
$engine = new Engine($petrinet);

// Starting the execution
$engine->start();

// Stopping the Execution
$engine->stop();
```

### Execution modes

There are two execution modes :

- `Stepped` : the engine will fire the currently enabled transitions, and stop itself.
- `Continuous` : the engine will fire the transitions until no more are enabled, and then stop itself.

By default the engine is in `Continuous` mode.

```php
<?php

// Changing the mode to "Stepped"
$engine->setMode(Engine::MODE_STEPPED);
```

### Events

The Petrinet framework is using Symfony
[EventDispatcher](http://symfony.com/doc/current/components/event_dispatcher/index.html) to dispatch its events.

Different events are available to interact with the engine or Petrinet elements during the execution process.

They are documented in the following [file](https://github.com/florianv/petrinet/blob/master/src/Petrinet/PetrinetEvents.php).

#### Examples

##### Listening to an EngineEvent

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\EventDispatcher\EventDispatcher;
use Petrinet\PetrinetEvents;
use Petrinet\Event\EngineEvent;
use Petrinet\PetrinetBuilder;
use Petrinet\Engine\Engine;

// Creating a simple Petrinet
$builder = new PetrinetBuilder('Network');

$petrinet = $builder
	->addPlace('p1', 1)
	->addTransition('t1')
	->addPlace('p2')
	->connectPT('p1', 't1')
	->connectTP('t1', 'p2')
	->getPetrinet();

$engine = new Engine($petrinet);
$dispatcher = new EventDispatcher();

// Listening to an EngineEvent
$listener = function (EngineEvent $e) {
	$petrinet = $e->getEngine()->getPetrinet();
	echo 'The execution of the Petrinet ' . $petrinet->getId() . ' just stopped';
};

// Adding the listener to the dispatcher
$dispatcher->addListener(PetrinetEvents::AFTER_ENGINE_STOP, $listener);

// Injecting the dispatcher into the engine
$engine->setDispatcher($dispatcher);

// Starting the execution
$engine->start();
```

##### Listening to TokenAndPlaceEvent

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\EventDispatcher\EventDispatcher;
use Petrinet\PetrinetEvents;
use Petrinet\Event\TokenAndPlaceEvent;
use Petrinet\PetrinetBuilder;
use Petrinet\Engine\Engine;

$builder = new PetrinetBuilder('Network');

$petrinet = $builder
	->addPlace('p1', 1)
	->addTransition('t1')
	->addPlace('p2')
	->connectPT('p1', 't1')
	->connectTP('t1', 'p2')
	->getPetrinet();

$engine = new Engine($petrinet);
$dispatcher = new EventDispatcher();

$listenConsumption = function (TokenAndPlaceEvent $e) {
	$placeId = $e->getPlace()->getId();
	echo sprintf('The place %s just dropped a token', $placeId);
};

$listenInsertion = function (TokenAndPlaceEvent $e) {
	$placeId = $e->getPlace()->getId();
	echo sprintf('The place %s just received a new token', $placeId);
};

$dispatcher->addListener(PetrinetEvents::AFTER_TOKEN_CONSUME, $listenConsumption);
$dispatcher->addListener(PetrinetEvents::AFTER_TOKEN_INSERT, $listenInsertion);
$engine->setDispatcher($dispatcher);
$engine->start();
```

### More examples

#### The Petrinet while function

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\EventDispatcher\EventDispatcher;
use Petrinet\Event\TransitionEvent;
use Petrinet\PetrinetBuilder;
use Petrinet\PetrinetEvents;
use Petrinet\Engine\Engine;

/**
 * Petrinet while function
 *
 * @param callable $while The while condition
 * @param callable $do    A callable to execute after each loop
 */
function petrinet_while($while, $do)
{
	$builder = new PetrinetBuilder('Loop');

	$petrinet = $builder
		->addPlace('p1', 1)
		->addTransition('t1')
		->addTransition('t2')
		->addPlace('p2')
		->connectPT('p1', 't1')
		->connectTP('t1', 'p2')
		->connectPT('p2', 't2')
		->connectTP('t2', 'p1')
		->getPetrinet();

	$engine = new Engine($petrinet);
	$dispatcher = new EventDispatcher();

	$listener = function (TransitionEvent $e) use ($engine, $while, $do) {
		if (!$while()) {
			$engine->stop();
		}

		call_user_func($do);
	};

	$dispatcher->addListener(PetrinetEvents::AFTER_TRANSITION_FIRE, $listener);
	$engine->setDispatcher($dispatcher);
	$engine->start();
}

// While condition
$while = function () {
	static $i = 0;

	if (5 === $i) {
		return false;
	}

	$i++;

	return true;
};

// Called after each loop
$do = function () {
	static $i = 0;
	echo $i;
	$i++;
};

petrinet_while($while, $do);
```