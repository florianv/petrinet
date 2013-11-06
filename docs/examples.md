# Petrinet Loop

```php
require_once __DIR__ . '/vendor/autoload.php';

// This function is equivalent to
for ($i = 1; $i < $iterations; $i++)
{
    call_user_func_array($callable, $i);
}

function petrinet_loop($iterations, $callable)
{
    $builder = new \Petrinet\PetrinetBuilder('pn');

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

    $engine = new \Petrinet\Engine\Engine($petrinet);
    $dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();

    $listener = function (\Petrinet\Event\TransitionEvent $e) use ($engine, $iterations, $callable) {
        static $i = 1;

        if ($iterations === $i) {
            $engine->stop();
        }

        call_user_func_array($callable, $i);
        $i++;
    };

    $dispatcher->addListener(\Petrinet\PetrinetEvents::AFTER_TRANSITION_FIRE, $listener);
    $engine->setDispatcher($dispatcher);
    $engine->start();
}

$callable = function ($i) {
    echo $i;
};

petrinet_loop(5, $callable);
```