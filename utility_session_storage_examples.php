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

echo '<a href="utility_session_storage_examples_2.php">Run Test</a><br />' . PHP_EOL;

echo '<pre>';
echo 'ArrayStorage -----------------------------' . PHP_EOL;
$manager1 = new SessionManager();
$manager1->setStorage(new ArrayStorage());
$container1 = new Container('test1', $manager1);
$container1->test = 'TEST1';

echo 'SessionStorage ---------------------------' . PHP_EOL;
$manager2 = new SessionManager();
$manager2->setStorage(new SessionStorage());
$container2 = new Container('test2', $manager2);
$container2->test = 'TEST2';

echo 'SessionArrayStorage ----------------------' . PHP_EOL;
$manager3 = new SessionManager();
$manager3->setStorage(new SessionArrayStorage());
$container3 = new Container('test3', $manager3);
$container3->test = 'TEST3';

echo '<pre>';
echo 'Default ----------------------------------' . PHP_EOL;
$container4 = new Container('test4');
$container4->test = 'TEST4';

echo '$_SESSION --------------------------------' . PHP_EOL;
var_dump($_SESSION);
echo '</pre>';
