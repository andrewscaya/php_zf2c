<?php
// TODO: test this!!! see wuzzup

// No need to do session_start(): this is done by
// the constructor defined in Zend\Session\AbstractContainer

include 'init_autoloader.php';

use Zend\Session\Storage\ArrayStorage;
use Zend\Session\Storage\SessionStorage;
use Zend\Session\Storage\SessionArrayStorage;
use Zend\Session\SessionManager;
use Zend\Session\Container;

echo '<a href="utility_session_storage_examples.php">BACK</a><br />' . PHP_EOL;

echo '<pre>';
echo 'ArrayStorage -----------------------------' . PHP_EOL;
$manager1 = new SessionManager();
$manager1->setStorage(new ArrayStorage());
$container1 = new Container('test1', $manager1);
echo 'Comes from array storage: ' . $container1->test . PHP_EOL;

echo 'SessionStorage ---------------------------' . PHP_EOL;
$manager2 = new SessionManager();
$manager2->setStorage(new SessionStorage());
$container2 = new Container('test2', $manager2);
echo 'Comes from session storage: ' . $container2->test . PHP_EOL;

echo 'SessionArrayStorage ----------------------' . PHP_EOL;
$manager3 = new SessionManager();
$manager3->setStorage(new SessionArrayStorage());
$container3 = new Container('test3', $manager3);
echo 'Comes from session array storage: ' . $container3->test . PHP_EOL;

echo '<pre>';
echo 'Default ----------------------------------' . PHP_EOL;
$container4 = new Container('test4');
echo 'Comes from default storage: ' . $container4->test . PHP_EOL;

// Works OK
echo '$_SESSION ---------------------------------' . PHP_EOL;
var_dump($_SESSION);
echo '</pre>';
