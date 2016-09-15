<?php
include 'init_autoloader.php';

use Zend\Session\SessionManager;
use Zend\Session\Validator\HttpUserAgent;
use Zend\Session\Validator\RemoteAddr;

$manager = new SessionManager();

$manager->start();

if (!isset($_GET['token']) || $_GET['token'] != '12345') {
    
    $manager->getValidatorChain()->attach('session.validate', [new HttpUserAgent(), 'isValid']);
    $manager->getValidatorChain()->attach('session.validate', [new RemoteAddr(), 'isValid']);

    $link = $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING'] . '&token=12345';
    echo '<a href="'. $link .'">*** CHANGE BROWSER ID ***</a><br />' . PHP_EOL;

} else {
    
    $manager->getValidatorChain()->attach('session.validate', [new HttpUserAgent('Some browser'), 'isValid']);
    
}

if (!$manager->isValid()) {
    echo 'Session is NOT valid<br />' . PHP_EOL;
} else {
    echo 'Session is valid<br />' . PHP_EOL;
}

phpinfo(INFO_VARIABLES);
