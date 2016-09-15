<?php
namespace Bar;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AbstractFooBarFactory implements AbstractFactoryInterface
{

    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator,
                                                $name,
                                                $requestedName)
    {
        if ($name === 'BarFoo') {
            return TRUE;
        }
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceLocator,
                                            $name,
                                            $requestedName)
    {
        return new \stdClass();
    }

}
