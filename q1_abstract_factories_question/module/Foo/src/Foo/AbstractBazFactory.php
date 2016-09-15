<?php
namespace Foo;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AbstractBazFactory implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name,
        $requestedName)
    {
        if ($name === 'FooBaz') {
            return TRUE;
        }
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name,
        $requestedName)
    {
        return new \stdClass();
    }
}
