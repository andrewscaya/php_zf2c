<?php
include 'init_autoloader.php';

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\Config;
use Zend\Db\Adapter\Adapter;

class AbstractTableGatewayFactory implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(
        ServiceLocatorInterface $serviceLocator,
        $name,
        $requestedName)
    {
        // does this classname end with Table?
        return fnmatch('*Table', $requestedName);
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name,
        $requestedName)
    {
        $adapter = $serviceLocator->get('db-adapter');
        return new TableGateway(str_replace('Table', '', $requestedName), $adapter);
    }
}

$config = new Config(array(
    'abstract_factories' => array(
        'AbstractTableGatewayFactory'
    ),
    'factories' => array(
        'db-adapter' => function($sm) { return new Adapter($sm->get('db')); },
    ),
    'service' => array(
        'db' => array(
            'driver' => 'pdo',
            'dsn' => 'mysql:hostname=localhost;dbname=zend',
            'username' => 'test',
            'password' => 'password',
        ),
    ),
));

$serviceManager = new ServiceManager($config);
$userTable = $serviceManager->get('UserTable');
Zend\Debug\Debug::dump($userTable);
