<?php
// Given the following class Test
// What will be the value of $diff?

include 'init_autoloader.php';

class Test
{
    protected $test    = 1;
    protected $my_test = 2;
    protected $myTest  = 3;    
    public function getTest()    { return $this->test;    }
    public function getMy_test() { return $this->my_test; }
    public function getMyTest()  { return $this->myTest;  }
}

$test      = new Test();
$hydrator1 = new Zend\Stdlib\Hydrator\Reflection();
$hydrator2 = new Zend\Stdlib\Hydrator\ClassMethods();
$diff      = array_diff($hydrator1->extract($test), $hydrator2->extract($test));
var_dump($diff);
var_dump($hydrator1->extract($test));
var_dump($hydrator2->extract($test));

// outputs this:
/*
array(3) {
  ["test"]=>
  int(1)
  ["my_test"]=>
  int(2)
  ["myTest"]=>
  int(3)
}
array(2) {
  ["test"]=>
  int(1)
  ["my_test"]=>
  int(3)
}
*/
