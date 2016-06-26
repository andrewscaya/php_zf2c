<?php
// NOTE: works thanks to Kevin G.

class Test
{
    protected $filtered = 'FILTERED';
    protected $testOne  = 'TEST1';
    protected $testTwo  = 'TEST1';

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

$hydrator = new ClassMethods();
$hydrator->addFilter('test', new MethodMatchFilter('getFiltered', TRUE), FilterComposite::CONDITION_OR);
$hydrator->removeFilter('get');

$result = $hydrator->extract(new Test());
print_r($result);
