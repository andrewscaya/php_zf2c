<?php
// what is the output from this code?
// (A) "12345"
// (B) "45123"
// (C) "45213"
// (D) "52412"

include 'init_autoloader.php';

// shared manager
$sem = new Zend\EventManager\SharedEventManager();
$sem->attach('*',  'someEvent', function() { echo "1";});
$sem->attach('Id', 'someEvent', function() { echo "2";});
$sem->attach('*',  'someEvent', function() { echo "3";});
$sem->attach('*',  'someEvent', function() { echo "4";}, 3);
$sem->attach('Id', 'someEvent', function() { echo "5";}, 2);

// a generic event manager instance
$evm1 = new Zend\EventManager\EventManager('Id');
$evm1->setSharedManager($sem);
$evm1->trigger('someEvent');
