<?php
// what is the output from this code?

include 'init_autoloader.php';

include 'init_autoloader.php';
// shared manager
$sem = new Zend\EventManager\SharedEventManager();
$sem->attach('*', 'someEvent', function() { echo "1";});
$sem->attach('Id', 'someEvent', function() { echo "2";});
$sem->attach('*', 'someEvent', function() { echo "3";});
$sem->attach('*', 'someEvent', function() { echo "4";}, 3);
$sem->attach('Id', 'someEvent', function() { echo "5";}, 2);
// a generic event manager instance
$evm1 = new Zend\EventManager\EventManager('Id');
$evm1->setSharedManager($sem);
$evm1->trigger('someEvent');
