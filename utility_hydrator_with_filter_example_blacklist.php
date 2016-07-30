<?php

class Test
{
    protected $filtered = 'FILTERED';
    protected $testOne  = 'TEST1';
    protected $testTwo  = 'TEST2';

    public function getFiltered() { return $this->filtered; }
    public function getTestOne()  { return $this->testOne;  }
    public function getTestTwo()  { return $this->testTwo;  }
    public function setFiltered($a) { $this->filtered = $a; }
    public function setTestOne($a)  { $this->testOne  = $a; }
    public function setTestTwo($a)  { $this->testTwo  = $a; }
}

include 'init_autoloader.php';

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\Filter\FilterComposite;
use Zend\Stdlib\Hydrator\Filter\MethodMatchFilter;

$hydrator = new ClassMethods(false);

// MethodMatchFilter will blacklist by default
$hydrator->addFilter(
    'getfiltered',
    new MethodMatchFilter('getFiltered'),
    FilterComposite::CONDITION_AND
);

$result = $hydrator->extract(new Test());
\Zend\Debug\Debug::dump($result);
